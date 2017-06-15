/**
 * Created by root on 05/06/17.
 */
var PeerJs = require('../peer.js');

module.exports = {
    props: [
        'skey','shost','sport','spath','ssecure','suser','soperator'
    ],
    data: function () {
        //console.log(this.skey,this.shost,this.sport,this.spath,this.ssecure,this.suser,this.soperator);
        return {
            peer: '',
            isRecording: false,
        };
    },
    template: require("../templates/videochat.template.html"),
    created:function () {
        console.log('created.....');
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
                port: (this.sport) ? this.sport : location.port || (location.protocol === 'https:' ? 443 : 80),
                path: this.spath,
                secure: (this.ssecure=='true')?true:false,
            });

        peer.on('open', function() {
            $('#call-id').text(realthis.peer.id);
        });
        peer.on('call', function(call) {
            console.log('call from Operator.....');
            this.isRecording = !this.isRecording;
            call.answer(window.localStream);
            that.wait_stream(call);
        });
        this.peer = peer;

    },
    methods:{
        calling:function () {
            console.log('Call ......');
            var that = this;
            this.isRecording = !this.isRecording;
            if (this.isRecording) {
                console.log('isRecording ......');
                navigator.getUserMedia({ audio: true, video: true}, function (stream) {
                    console.log('inStream ......');
                    $('#localVideo').prop('src', URL.createObjectURL(stream));
                    window.localStream = stream;
                    var call = that.peer.call(that.soperator, window.localStream);
                    that.wait_stream(call);
                }, function(err){console.log(err);});
            } else {
                window.existingCall.close();
                $('#localVideo').prop('src','');
                $('#remoteVideo').prop('src','');
            };
        },
        wait_stream: function (call) {
            if (window.existingCall) {
                window.existingCall.close();
            }
            call.on('stream', function(stream){
                $('#remoteVideo').prop('src', URL.createObjectURL(stream));
            });
            call.on('close', function () {
                window.existingCall.close();
                $('#localVideo').prop('src','');
                $('#remoteVideo').prop('src','');
            });
            window.existingCall = call;
        }
    }


};