/**
 * Created by root on 05/06/17.
 */
var PeerJs = require('../peer.js');

module.exports = {
    props: [
        'skey','shost','sport','spath','ssecure','suser','soperator'
    ],
    data: function () {
        return {
            peer: '',
            isRecording: false,
            //stream: ''
        };
    },
    template: require("../templates/videochat.template.html"),
    created:function () {
        console.log('created.....');
        //console.log(this.skey,this.shost,this.sport,this.spath,this.ssecure,this.suser,this.soperator);
        navigator.getUserMedia = navigator.getUserMedia ||
            navigator.webkitGetUserMedia ||
            navigator.mozGetUserMedia ||
            navigator.mediaDevices.getUserMedia ||
            navigator.msGetUserMedia;

        var realthis = this;
        var peer = new Peer(this.suser,
            {
                key: this.skey,
                host: this.shost,
                port: (this.sport ? this.sport : location.port || (location.protocol === 'https:' ? 443 : 80)),
                path: this.spath,
                secure: (this.ssecure == true)?true:false
            });

        peer.on('open', function() {
            console.log('opened.....'+peer.id);
            //$('#call-id').text(peer.id);
        });

        peer.on('error', function(err) {
            console.log(err.message);
        });

        peer.on('call', function(call) {
            console.log('call from Operator.....');
            this.isRecording = !this.isRecording;
            $('#localVideo').show();
            call.answer(window.localStream);
            realthis.wait_stream(call);
        });

        navigator.getUserMedia({ audio: true, video: true}, function (stream) {
            console.log('inStream 10101010 ......');
            window.localStream = stream;
            $('#localVideo').prop('src',  URL.createObjectURL(stream));
            this.stream = URL.createObjectURL(stream);
        }, function(err){console.log(err);});


        this.peer = peer;

    },
    methods:{
        calling:function () {
            console.log('Call ......');
            //var that = this;
            this.isRecording = !this.isRecording;
            if (this.isRecording) {
                console.log('isRecording ......');
                //$('#localVideo').prop('src', window.localStream);
                var call = this.peer.call(this.soperator, window.localStream);
                this.wait_stream(call);
            } else {
                window.existingCall.close();
                $('#localVideo').prop('src','');
                $('#remoteVideo').prop('src','');
            }
        },
        wait_stream: function (call) {
            console.log(' wait_stream...');
            if (window.existingCall) {
                window.existingCall.close();
            }
            call.on('stream', function(stream){
                $('#remoteVideo').prop('src', URL.createObjectURL(stream));
            });
            call.on('close', function () {
                console.log('closa call...');
                window.existingCall.close();
                this.isRecording = !this.isRecording;
                $('#localVideo').prop('src','');
                $('#remoteVideo').prop('src','');
            });
            window.existingCall = call;
        }
    }


};