<template xmlns="http://www.w3.org/1999/html">
<div v-show="isRecording" id="draggable" class="ui-widget-content">

    <button id="btmStop" class="btn btn-warning" v-on:click.prevent="close_call">
        <i class="fa fa-stop" ></i>
        <span >Termina</span>
    </button>
    <span class="text-center">{{(countdown != 0)?countdown:''}}</span>
    <button id="btnRecord" class="btn btn-primary pull-right col-md-4" v-on:click.prevent="record_call">
        <i v-show="!record" class="fa fa-toggle-off">&nbsp;<span>Registra</span></i>
        <i v-show="record" class="fa fa-toggle-on" style="color: red">&nbsp;<span>Stop</span></i>
    </button>
    <br />
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
        $( "#draggable" ).draggable({
            handle:'#remoteVideo',
        });
    });



var PeerJs = require('../peer.js');
var RecordRTC = require('recordrtc');

module.exports = {
    props: [
        'skey','shost','sport','spath','ssecure','suser','slocation'
    ],
    data: function () {
        console.log('Connection from: '+this.suser);
        var realport = (this.sport ? this.sport : location.port || (location.protocol === 'https:' ? 443 : 80));
        var options = {
            mimeType: 'video/webm;codecs=vp9', // or video/webm\;codecs=h264 or video/webm\;codecs=vp9
            bitsPerSecond: 128000 // if this line is provided, skip above two
        };
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
            remoteID: 0,
            isRecording: false,
            record:false,
            recOpt: options,
            recordRTC: '',
            border_time:0,
            record_time:0,
            borderTimeEvt: true,
            maxRecordTime: (1 * 60 * 1000),
            countdown: 0,
            elapsedTime:0,
        };
    },
    created:function () {
        console.log('created.....');
        var that=this;

        navigator.getUserMedia = navigator.getUserMedia ||
            navigator.webkitGetUserMedia ||
            //navigator.mozGetUserMedia ||
            navigator.mediaDevices.getUserMedia ||
            navigator.msGetUserMedia;

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
        }, function(err){console.log(err)});

        this.peer.on('open', function() {
            console.log('opened.....');
        });

        this.peer.on('error', function(err) {
            console.log(err.message);
        });

        this.peer.on('call', function(call) {
            //$('#localVideo').prop('src',  URL.createObjectURL(window.localStream));
            call.answer(window.localStream);
            console.log('call from User.....');
            that.isRecording = !that.isRecording;
            that.wait_stream(call);
        });

    },
    computed:function () {



    },
    methods: {
        close_call:function () {
            console.log('Close Call .....');
            if (window.existingCall) {
                window.existingCall.close();
            }
            Event.$emit('close-call',this.remoteID);
        },
        wait_stream: function (call) {
            var that = this;
            console.log(' wait_stream...');
            if (window.existingCall) {
                window.existingCall.close();
            }
            call.on('stream', function(stream){
                console.log('call in stream...');
                $('#remoteVideo').prop('src', URL.createObjectURL(stream));
                that.recordRTC = RecordRTC(stream,that.recOpt);
            });
            call.on('close', function () {
                console.log('close call...');
                window.existingCall.close();
                that.isRecording = false;

                //$('#localVideo').prop('src','');
                $('#remoteVideo').prop('src','');
            });
            this.remoteID = call.peer;
            window.existingCall = call;
        },
        record_call:function () {
            var vm = this;
            vm.record = !vm.record;
            if(vm.record){
                vm.recordRTC.startRecording();
                vm.border_time = setInterval(function () {
                    console.log('border  time out ....');
                    vm.countdown = new Date(vm.maxRecordTime-vm.elapsedTime).toISOString().slice(11, 19);
                    vm.elapsedTime += 1000;
                    vm.borderTimeEvt = !vm.borderTimeEvt;
                    /*(vm.borderTimeEvt)?
                        $('#remoteVideo').css("border","dashed 3px red"):
                        $('#remoteVideo').css("border","dashed 3px green");*/
                    (vm.borderTimeEvt)?
                        $('#remoteVideo').css({border: 'dashed 4px red'}).animate("slow"):
                        $('#remoteVideo').css({border: 'solid 4px blue'}).animate("slow");
                },1000);
                vm.record_time = setTimeout(function () {
                    console.log('Max record  time out ....');
                    vm.elapsedTime = 0;
                    vm.recordRTC.stopRecording();
                    clearInterval(vm.border_time);
                    $('#remoteVideo').css('border','none');
                    vm.border_time = false;
                },vm.maxRecordTime);
            } else {
                vm.recordRTC.stopRecording(function (audioVideoWebMURL) {
                    //var recordedBlob = vm.recordRTC.getBlob();
                    //vm.recordRTC.save('File Name');
                    this.save();
                });
                vm.elapsedTime = 0;
                clearInterval(vm.border_time);
                clearTimeout(vm.maxRecord_time);
                $('#remoteVideo').css('border','none');
            }
        },

    },




};
</script>

<style scoped>
#draggable {
    color: ;
    position: absolute;
    background-color: white;
    z-index: 1000;
    width: 400px;
    height: 300px;
    //padding: 0.5em;
    box-shadow: 5px 5px 10px #888;
    -moz-box-shadow: 5px 5px 10px #888;0
    -webkit-box-shadow: 5px 5px 10px #888;
}

#divLocalVideo{
    background-color: black;
    width: 30%;
    position: absolute;
    top: 0px;
    right: -10px;
    box-shadow: 5px 5px 10px #888;
    -moz-box-shadow: 5px 5px 10px #888;
    -webkit-box-shadow: 5px 5px 10px #888;
}

#divRemoteVideo {
    position: relative;
}

</style>