<template>
    <div>
        <button v-bind:class="[isStarted?'btn btn-danger':'btn btn-primary']" v-on:click.stop.prevent="calling_new">
            <i class="fa fa-stop" v-show="isStarted"></i>
            <i class="fa fa-play" v-show="!isStarted"></i>
            <span v-show="!isStarted">Chiama Operatore</span>
            <span v-show="isStarted">Termina Chiamata</span>
        </button>
        <br>
        <div v-show="isWaiting" id="call-id" class="text-center">
            <img src="../../../../public/images/animated-telephone.gif" width="100px">
        </div>
        <div id='divRemoteVideo' v-show="isStarted">

            <video id="remoteVideo" style="height: 350px;" autoplay></video>
            <div id='divLocalVideo' >
                <video id="localVideo" autoplay height="100%"></video>
            </div>
        </div>
        <div v-show="isRecording" class="pull-right">Recording ......</div>
        <div v-show="noResponse" id="noResponse">NO AVAILABLE OPERATOR...</div>
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
            isStarted: false,
            isRecording:false,
            isWaiting:false,
            noResponse:false,
            userDetail:{userId: this.suser,status:'ready',locations:this.slocation,userType:"user"}
        };
    },
    created:function () {
        console.log('created.....');
        console.log(this.skey,this.shost,this.sport,this.spath,this.ssecure,this.suser,this.slocation);

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
            realthis.isStarted = !realthis.isStarted;
            realthis.wait_stream(call);
        });*/
///// SOCKET IO
        this.io.emit('welcome-message', this.userDetail);

        this.io.on('no-response-available',function () {
            vm.destroyLocalUserMedia;
            vm.isWaiting = false;
            vm.noResponse = true;
            console.log('no-response-available......');
        });

        this.io.on('timeout-response',function () {
            vm.destroyLocalUserMedia;
            vm.isWaiting = false;
            vm.noResponse = true;
            console.log('timeout-response......');
        });

        this.io.on('recording-call',function (message) {
            vm.isRecording = message.isRecording;
        });


        this.io.on('new-response-arrived',function (message) {
            console.log('new-response-arrived......'+JSON.stringify(message));
            vm.isRecording = false;
            vm.calling(message.userToCall);
        });


    },
    computed: {
        getLocalUserMedia: function () {
            navigator.getUserMedia = navigator.getUserMedia ||
                navigator.webkitGetUserMedia ||
                navigator.mozGetUserMedia ||
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

            return;
        },
        destroyLocalUserMedia: function () {
            if (window.existingCall) {
                window.existingCall.close();
                window.existingCall.stop();
            }
            return;
        }

    },
    methods:{
        calling_new: function(){
            console.log('io.emit...........');

            this.destroyLocalUserMedia;
            this.getLocalUserMedia;
            this.io.emit('ask-response', {location: this.slocation});
            this.isWaiting = true;
        },

        calling:function (userToCall) {
            console.log('Call Operator ......');
            var vm = this;

            this.isStarted = !this.isStarted;
            if (this.isStarted) {
                console.log('isStarted ......');
                try {
                    var call = vm.peer.call(userToCall, window.localStream);
                    vm.wait_stream(call);
                } catch (err) {
                    console.log('Chiama a '+userToCall+' non possibile ......'+err);
                }
            } else {
                this.destroyLocalUserMedia;
                //$('#localVideo').prop('src','');
                $('#remoteVideo').prop('src','');
            }
        },
        wait_stream: function (call) {
            this.isWaiting = false;
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
                if (vm.isStarted) {
                    vm.isStarted = !vm.isStarted;
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

    #noResponse {
        font-size: large;
        font-weight: bold;
        animation: blinker 1s linear infinite;
    }

    @keyframes blinker {
        50% { opacity: 0; }
    }

</style>