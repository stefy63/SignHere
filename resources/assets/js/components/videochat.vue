<template>
    <div>
        <button v-bind:class="[isRecording?'btn btn-danger':'btn btn-primary']" v-on:click.stop.prevent="calling_new">
            <i class="fa fa-stop" v-show="isRecording"></i>
            <i class="fa fa-play" v-show="!isRecording"></i>
            <span v-show="!isRecording">Chiama Operatore</span>
            <span v-show="isRecording">Termina Chiamata</span>
        </button>
        <br>
        <!--<div id="call-id"></div>-->
        <div id='divRemoteVideo' v-show="isRecording">
            <video id="remoteVideo" style="height: 350px;" autoplay></video>
            <div id='divLocalVideo' >
                <video id="localVideo" autoplay height="100%"></video>
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">

/**
 * Created by root on 05/06/17.
 */
var PeerJs = require('../peer.js');
var socket = require('socket.io-client');


module.exports = {
    props: [
        'skey','shost','sport','spath','ssecure','suser','slocation'
    ],
    data: function () {
        console.log(this.ssecure);
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
                        urls: 'stun:stun.l.google.com:19302'
                    }, {
                        urls: 'stun:stun1.l.google.com:19302'
                    }, {
                        urls: 'stun:stun2.l.google.com:19302'
                    }, {
                        urls: 'stun:stun3.l.google.com:19302'
                    }]
                }
            });
        return {
            io: socket.connect(this.shost+':'+realport),
            peer: video,
            isRecording: false,
            userDetail:{userId: this.suser,status:'ready',locations:this.slocation,userType:"user"}
        };
    },
    created:function () {
        console.log('created.....');
        console.log(this.skey,this.shost,this.sport,this.spath,this.ssecure,this.suser,this.slocation);

        navigator.getUserMedia = navigator.getUserMedia ||
            navigator.webkitGetUserMedia ||
            //navigator.mozGetUserMedia ||
            navigator.mediaDevices.getUserMedia ||
            navigator.msGetUserMedia;

        navigator.getUserMedia({ audio: {
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

        var vm = this;

        this.peer.on('open', function() {
            console.log('opened.....');
        });

        this.peer.on('error', function(err) {
            console.log(err.message);
        });

        /*this.peer.on('call', function(call) {
            call.answer(window.localStream);
            console.log('call from Operator.....');
            realthis.isRecording = !realthis.isRecording;
            realthis.wait_stream(call);
        });*/
///// SOCKET IO
        this.io.emit('welcome-message', this.userDetail);

        this.io.on('no-response-available',function () {
            console.log('no-response-available......');
        });

        this.io.on('new-response-arrived',function (message) {
            console.log('new-response-arrived......'+JSON.stringify(message));
            vm.calling(message.userToCall);
        });


    },
    computed: function () {

    },
    methods:{
        calling_new: function(){
            console.log('io.emit...........');
            if (window.existingCall) {
                window.existingCall.close();
            }
            this.io.emit('ask-response', {location: this.slocation});
        },

        calling:function (userToCall) {
            console.log('Call Operator ......');
            var vm = this;

            this.isRecording = !this.isRecording;
            if (this.isRecording) {
                console.log('isRecording ......');
                try {
                    var call = vm.peer.call(userToCall, window.localStream);
                    vm.wait_stream(call);
                } catch (err) {
                    console.log('Chiama a '+userToCall+' non possibile ......'+err);
                }
            } else {
                window.existingCall.close();
                //$('#localVideo').prop('src','');
                $('#remoteVideo').prop('src','');
            }
        },
        wait_stream: function (call) {
            var vm = this;
            console.log(' wait_stream...');
            if (window.existingCall) {
                window.existingCall.close();
            }
            call.on('stream', function(stream){
                console.log('call in stream...');
                $('#remoteVideo').prop('src', URL.createObjectURL(stream));
            });
            call.on('close', function () {
                console.log('close call...');
                window.existingCall.close();
                if (vm.isRecording) {
                    vm.isRecording = !vm.isRecording;
                }
                //$('#localVideo').prop('src','');
                $('#remoteVideo').prop('src','');
            });
            window.existingCall = call;
        }
    }


};
</script>

<style scoped>
    #divLocalVideo{
        background-color: black;
        width: 30%;
        position: absolute;
        top: -3px;
        right: -3px;
        box-shadow: 5px 5px 10px #888;
        -moz-box-shadow: 5px 5px 10px #888;
        -webkit-box-shadow: 5px 5px 10px #888;
    }

    #divRemoteVideo {
        position: relative;
    }

</style>