<template>
    <div style="border: thin solid lightgray;border-radius: 6px;padding: 8px;">
        <vue-web-cam
                ref="webcam"
                :device-id="deviceId"
                width="100%"
                @started="onStarted"
                @stopped="onStopped"
                @error="onError"
                @cameras="onCameras"
                @camera-change="onCameraChange"
        />
        <div class="row">
            <div class="col-md-12">
                <select v-model="camera" class="form-control" >
                    <option>-- Select Device --</option>
                    <option
                            v-for="device in devices"
                            :key="device.deviceId"
                            :value="device.deviceId"
                    >{{ device.label }}</option>
                </select>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-4">
                <button class="form-control btn-sm" @click="onCapture">Capture</button>
            </div>
            <div class="col-4">
                <button class="form-control btn-sm" @click="onStop">Stop</button>
            </div>
            <div class="col-4">
                <button class="form-control btn-sm btn-primary" @click="onStart">Start</button>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-12">
                <img :src="img" class="img-responsive" style="width: 100%;height: auto;" />
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "PhotoCam",
        model: {
            prop: 'value',
            event: 'input'
        },
        props: {
            value: {
                type: [Object, Array, String],
                default: function(){
                    return {};
                }
            },
            uploadurl : {
                type: String,
                default: 'api/v1/core/upload'
            },
            handle : {
                type: String
            },
            ns : {
                type: String
            },
            mode : {
                type: String
            },
            defaulturl : {
                type: String,
                default: 'images/coffee.png'
            },
            buttonlabel : {
                type: String,
                default: 'Click or Drag and Drop files here to upload'
            },
        },

        data: function(){
            return {
                img: null,
                camera: null,
                deviceId: null,
                devices: []
            }
        },
        watch: {
            camera: function(id) {
                this.deviceId = id;
            },
            devices: function() {
                // Once we have a list select the first one
                const [first, ...tail] = this.devices;
                if (first) {
                    this.camera = first.deviceId;
                    this.deviceId = first.deviceId;
                }
            }
        },
        methods: {
            onCapture() {
                this.img = this.$refs.webcam.capture();
            },
            onStarted(stream) {
                console.log("On Started Event", stream);
            },
            onStopped(stream) {
                console.log("On Stopped Event", stream);
            },
            onStop() {
                this.$refs.webcam.stop();
            },
            onStart() {
                this.$refs.webcam.start();
            },
            onError(error) {
                console.log("On Error Event", error);
            },
            onCameras(cameras) {
                this.devices = cameras;
                console.log("On Cameras Event", cameras);
            },
            onCameraChange(deviceId) {
                this.deviceId = deviceId;
                this.camera = deviceId;
                console.log("On Camera Change Event", deviceId);
            }
        }
    }
</script>

<style scoped>

</style>
