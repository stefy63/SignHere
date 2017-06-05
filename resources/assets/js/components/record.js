

module.exports = {
    data: function () {
        return {
            isRecording: false,
            audioRecorder: null,
            recordingData: [],
            dataUrl: []
        };
    },
    template: require("../templates/record.html"),
    methods:
    {
        toggleRecording: function() {
            var that = this;
            this.isRecording = !this.isRecording;
            if (this.isRecording) {
                navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia;
                navigator.getUserMedia({
                        audio: true,
                        video: true
                    }, function(stream) {
                        that.stream = stream;
                        that.audioRecorder = new MediaRecorder(stream,{mimeType: 'video/webm; codecs=vp9'});
                        that.audioRecorder.ondataavailable = function (e) {
                            if (event.data.size > 0) {
                                that.dataUrl.push(e.data);
                              }
                        };
                        that.audioRecorder.start();
                        console.log('Media recorder started');
                    }, function(error) {
                        alert(JSON.stringify(error));
                });
            }
            else {
                this.audioRecorder.stop();
            }
        },
        removeRecording: function() {
            this.isRecording = false;
            this.recordingData = [];
            this.dataUrl = '';
        },
        togglePlay: function() {
            var audioElement = document.getElementById("audio");
            if (audioElement.paused === false) {
                audioElement.pause();
            } else {
                audioElement.play();
            }
        },
        submitRecording: function() {
            var that = this;
            var blob = new Blob(that.recordingData , { type: 'audio/ogg'});
            var formData = new FormDat();
            formData.append('recording', blob);
            this.$http.post('/recording', formData)
        }
    },
};
