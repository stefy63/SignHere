<template>
<div v-show="isRecording" id="draggable" class="ui-widget-content">
    <button class="btn btn-warning col-md-5" onClick="javascript:alert('dsadsda');" v-on:click.stop.prevent="close_call">
        <i class="fa fa-stop" ></i>
        <span >Termina</span>
    </button>

    <button class="btn btn-danger col-md-5 pull-right" >
        <i class="fa fa-toggle-off"></i>
        <span >Registra</span>
    </button>

    <div id='divRemoteVideo' >
        <video id="remoteVideo" autoplay></video>
        <div id='divLocalVideo' >
            <video id="localVideo" autoplay height="100%"></video>
        </div>
    </div>
</div>
</template>

<script type="text/javascript">
    $(function () {
        $( "#draggable" ).draggable();
    });



var PeerJs = require('../peer.js');

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
                        urls: 'stun:stun.ekiga.net'
                    }, {
                        urls: 'stun:stun.l.google.com:19302'
                    }, {
                        urls: 'stun:stun1.l.google.com:19302'
                    }, {
                        urls: 'stun:stun2.l.google.com:19302'
                    }, {
                        urls: 'stun:stun3.l.google.com:19302'
                    }, {
                        urls: 'stun:stun4.l.google.com:19302'
                    }]
                }
            });
        return {
            peer: video,
            isRecording: false,
        };
    },
    created:function () {
        var that=this;

        navigator.getUserMedia = navigator.getUserMedia ||
            navigator.webkitGetUserMedia ||
            navigator.mozGetUserMedia ||
            navigator.mediaDevices.getUserMedia ||
            navigator.msGetUserMedia;


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
    methods: {
        close_call:function () {
            console.log('Close Call .....');
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
#draggable {
    position: absolute;
    z-index: 1000;
    width: 300px;
    height: 250px;
    //padding: 0.5em;
    box-shadow: 5px 5px 10px #888;
    -moz-box-shadow: 5px 5px 10px #888;0
    -webkit-box-shadow: 5px 5px 10px #888;
}

#divLocalVideo{
    background-color: black;
    width: 30%;
    position: absolute;
    top: 35px;
    right: -10px;
    box-shadow: 5px 5px 10px #888;
    -moz-box-shadow: 5px 5px 10px #888;
    -webkit-box-shadow: 5px 5px 10px #888;
}

#divRemoteVideo {
    position: relative;
}

</style>