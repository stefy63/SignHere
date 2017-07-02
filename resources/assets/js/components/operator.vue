<template>
<div>
    <div v-show="numCall" id="small-videochat" v-bind:class="[timeOut?'animated wobble':'animated pulse']" >
        <span v-show="!isRecording" class="badge badge-danger pull-right">{{ numCall }}</span>
        <a v-show="!isRecording"  class="open-small-videochat" v-on:click.stop.prevent="accept_call">
            <i class="fa fa-video-camera"></i>
        </a>

        <button v-show="isRecording" class="btn btn-danger" v-on:click.stop.prevent="close_call">
            <i class="fa fa-stop" v-show="isRecording"></i>
            <span v-show="isRecording">Termina Chiamata</span>
        </button>

        <div style="position: relative" v-show="isRecording">
            <video id="remoteVideo" style="height: 350px;" autoplay></video>
            <div style="
            background-color: black;
            width: 30%;
            position: absolute;
            top: -3px;
            right: -3px;
            box-shadow: 5px 5px 10px #888;
            -moz-box-shadow: 5px 5px 10px #888;
            -webkit-box-shadow: 5px 5px 10px #888;
            " >
                <video id="localVideo" autoplay height="100%"></video>
            </div>
        </div>
    </div>
</div>
</template>

<script type="text/javascript">

var PeerJs = require('../peer.js');
//var PeerJs = require('peer').ExpressPeerServer;
var socket = require('socket.io-client');


module.exports = {
    props: [
        'skey','shost','sport','spath','ssecure','suser','slocation'
    ],
    data: function () {
        console.log('Connection from: '+this.suser);
        var realport = (this.sport ? this.sport : location.port || (location.protocol === 'https:' ? 443 : 80));
        var video = new Peer(this.suser,
            {
                key: this.skey,
                host: this.shost,
                port: realport,
                path: this.spath,
                secure: (this.ssecure == true)?true:false,
                config:{
                    'iceServers': [{
                        url: 'stun:stun.ekiga.net'
                    }, {
                        url: 'stun:stun.l.google.com:19302'
                    }, {
                        url: 'stun:stun1.l.google.com:19302'
                    }, {
                        url: 'stun:stun2.l.google.com:19302'
                    }, {
                        url: 'stun:stun3.l.google.com:19302'
                    }, {
                        url: 'stun:stun4.l.google.com:19302'
                    }]
                }
            });
        return {
            Call: [],
            numCall:0,
            setLoop:0,
            io: socket.connect(this.shost+':'+realport),
            peer: video,
            isRecording: false,
            timeOut: false,
            userDetail:{userId: this.suser,status:'ready',locations:this.slocation,userType:"operator"}
        };
    },
    created:function () {
        var that=this;

        navigator.getUserMedia = navigator.getUserMedia ||
            navigator.webkitGetUserMedia ||
            navigator.mozGetUserMedia ||
            navigator.mediaDevices.getUserMedia ||
            navigator.msGetUserMedia;


        this.numCall = this.Call.length;

        this.io.emit('welcome-message',this.userDetail );

        this.io.on('new-call-arrived',this.new_call);

        this.io.on('operator-notify-stop-ask-response',this.stop_ask_response);
        this.io.on('operator-notify-response',this.other_response);


        this.peer.on('open', function() {
            console.log('opened.....');
        });

        this.peer.on('error', function(err) {
            console.log(err.message);
        });

        this.peer.on('call', function(call) {
            call.answer(window.localStream);
            console.log('call from Operator.....');
            that.isRecording = !that.isRecording;
            clearInterval(that.setLoop);
            that.wait_stream(call);
        });


    },
    computed: function() {
        var that=this;
        if(this.numCall == 0) {
            $('#small-videochat').hide();
        } else {
            $('#small-videochat').show();
        }
    },
    methods: {
        new_call:function (message) {
            var that = this;
            if(this.Call.indexOf(message.userId) != -1){
                return;
            }
            this.Call.push(message.userId);
            this.numCall = this.Call.length;
            console.log('new-response-arrived......'+message.userId+' - '+this.numCall);
            console.log(JSON.stringify(this.Call));
            if(!that.setLoop){
                that.setLoop = setInterval(function () {
                    that.timeOut = !that.timeOut;
                },3000);
            }

        },
        stop_ask_response:function (message) {
            this.Call.splice($.inArray(message.userId, this.Call), 1 );
            this.numCall = this.Call.length;
            console.log('response-check-user-connection......');
        },
        other_response:function (message) {
            if(message.operatorId != this.suser) this.stop_ask_response(message);
        },
        close_call:function () {
            if (window.existingCall) {
                window.existingCall.close();
            }
        },
        accept_call:function () {
            var that = this;
            console.log('Small-Chat-Clikked....');

            if (window.existingCall) {
                window.existingCall.close();
            }

            navigator.getUserMedia({ audio:{
                "mandatory": {
                    echoCancellation: true,
                    googEchoCancellation: true,
                    googAutoGainControl: true,
                    googNoiseSuppression: true,
                    googHighpassFilter: true
                },
                "optional": []
                }, video: true}, function (stream) {
                    console.log('getUserMedia ......');
                    window.localStream = stream;
                    $('#localVideo').prop('src',  URL.createObjectURL(stream));
                }, function(err){console.log(err);});

            var user2call = {userToCall: this.Call[0] ,location: 5};
            this.io.emit('accept-call',user2call);
        },
        wait_stream: function (call) {
            var that = this;
            console.log(' wait_stream...');
            /*if (window.existingCall) {
                window.existingCall.close();
            }*/
            call.on('stream', function(stream){
                console.log('call in stream...');
                $('#remoteVideo').prop('src', URL.createObjectURL(stream));
            });
            call.on('close', function () {
                that.Call.splice(0 , 1 );
                that.numCall = that.Call.length;
                console.log('close call...');
                window.existingCall.close();
                that.isRecording = false;

                //$('#localVideo').prop('src','');
                //$('#remoteVideo').prop('src','');
            });
            window.existingCall = call;
        },
    },




};
</script>

<style scoped>
#small-videochat {
    position: fixed;
    top: 2px;
    left:2px;
    z-index: 100;
}

.open-small-videochat {
  height: 38px;
  width: 38px;
  display: block;
  background: #1ab394;
  padding: 9px 8px;
  text-align: center;
  color: #fff;
  border-radius: 50%;
}
</style>