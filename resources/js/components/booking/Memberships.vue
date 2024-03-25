<template>
  <div>
    <div class="row justify-content-center g-0 mt-4" v-show="!selectedTicket">
      <booking-plans
        v-for="(pricing, index) in packages"
        :key="index"
        :pricing="pricing"
        @buyTicketForm="buyTicketForm"
      />
    </div>
    <div v-if="selectedTicket" class="animate__animated animate__fadeIn">
      <form class="space-y-4 card" style="padding: 3rem 3rem">
        <h2 class="card-title">{{ selectedTicket.title }}</h2>
        <div class="card-body p-6">
          <div class="row">
            <div class="col-md-12 mt-3">
              <div class="mt-3">
                <h6 class="section-title-h6">some text here</h6>
              </div>
            </div>
            <div class="col-md-6" v-if="selectedTicket.type === 'membership'">
              <input
                type="file"
                ref="fileInput"
                @change="handleFileChange"
                accept="image/*"
                style="display: none"
              />
              <button
                type="button"
                class="btn btn-sm inline-flex justify-center btn-dark mt-4 w-full"
                @click="openFileInput"
              >
                Upload Image
              </button>

              <div class="image-preview" v-if="!isCameraOpen">
                <img :src="previewUrl" alt="Preview" v-if="previewUrl" />
              </div>

              <video
                ref="camera"
                v-if="isCameraOpen"
                autoplay
                width="450"
                height="337.5"
              ></video>
              <canvas
                ref="canvas"
                id="photoTaken"
                v-if="isPhotoTaken"
                width="450"
                height="337.5"
                style="display: none"
              ></canvas>

              <div class="upload-options">
                <div>
                  <button
                    type="button"
                    @click="takePhoto"
                    :disabled="isPhotoTaken"
                    v-if="isCameraOpen"
                    class="btn btn-sm inline-flex justify-center btn-dark mt-4 w-full"
                  >
                    Take Photo
                  </button>
                  <span class="text-sm">OR</span>
                  <br />
                  <button
                    type="button"
                    @click="toggleCamera"
                    class="btn btn-sm inline-flex justify-center btn-dark mt-4 w-full"
                  >
                    {{ isCameraOpen ? "Close Camera" : "Live Camera" }}
                  </button>
                </div>
              </div>
            </div>
            <div
              :class="
                selectedTicket.type === 'membership' ? 'col-md-6' : 'col-md-12'
              "
            >
              <div class="row">
                <div
                  :class="
                    selectedTicket.type === 'membership'
                      ? 'col-md-12'
                      : 'col-md-4'
                  "
                >
                  <div class="input-area relative">
                    <label
                      for="phone"
                      class="form-label"
                      style="font-size: 13px; font-weight: 500"
                      ><span>First Name</span
                      ><span class="text-danger"> * </span></label
                    >
                    <div>
                      <input
                        type="text"
                        name="name"
                        id="name"
                        class="form-control"
                        placeholder=""
                      />
                    </div>
                  </div>
                </div>

                <div
                  :class="
                    selectedTicket.type === 'membership'
                      ? 'col-md-12'
                      : 'col-md-4'
                  "
                >
                  <div class="input-area relative">
                    <label for="turning" class="form-label label-text"
                      ><span>Last Name</span>
                    </label>
                    <div>
                      <input
                        type="number"
                        name="turning"
                        id="staturningte"
                        class="form-control"
                        placeholder=""
                      />
                    </div>
                  </div>
                </div>
                <div
                  :class="
                    selectedTicket.type === 'membership'
                      ? 'col-md-12'
                      : 'col-md-4'
                  "
                >
                  <div class="input-area relative">
                    <label for="turning" class="form-label label-text"
                      ><span> Phone</span>
                    </label>
                    <div>
                      <input
                        type="number"
                        name="turning"
                        id="staturningte"
                        class="form-control"
                        placeholder=""
                      />
                    </div>
                  </div>
                  <button
                    type="submit"
                    class="btn btn-sm inline-flex justify-center btn-dark mt-4 w-full"
                  >
                    Submit
                  </button>
                  <a
                    class="mt-4 justify-center"
                    @click="
                      () => ((selectedTicket = null), (previewUrl = null))
                    "
                    href="javascript:void(0)"
                  >
                    Cancel
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import BookingPlans from "@/components/booking/Plans.vue";

export default {
  components: {
    BookingPlans,
  },
  props: ["slots"],

  data() {
    return {
      previewUrl: null,

      selectedDate: null,
      selectedTicket: null,
      isCameraOpen: false,
      isPhotoTaken: false,
      isShotPhoto: false,
      isLoading: false,
      link: "#",
      slotRooms: [],

      packages: [
        {
          title: "Entry",
          price: "449.99",
          type: "membership",

          features: [
            "Full Conference (workshop, coffee etc)",
            "Live Videos (Can access online free)",
            "Meet Speaker (Ask questions privately)",
          ],
          speed: -0.5,
        },
        {
          title: "Entry + Sock",
          price: "90",
          type: "entries",
          features: [
            "Full Conference (workshop, coffee etc)",
            "Live Videos (Can access online free)",
            "Meet Speaker (Ask questions privately)",
          ],
          speed: 0.5,
          featured: true,
        },
        {
          title: "Entry + Sock + Arcade",
          price: "649.99",
          type: "entries",
          features: [
            "Full Conference (workshop, coffee etc)",
            "Live Videos (Can access online free)",
            "Meet Speaker (Ask questions privately)",
          ],
          speed: -0.5,
        },
      ],
    };
  },
  mounted() {
    // Ensure the canvas is ready for use when the component is mounted
    this.$nextTick(() => {
      const canvas = this.$refs.canvas;
      if (canvas) {
        canvas.getContext("2d");
      }
    });
  },
  methods: {
    toggleCamera() {
      if (this.isCameraOpen) {
        this.isCameraOpen = false;
        this.isPhotoTaken = false;
        this.isShotPhoto = false;
        this.stopCameraStream();
      } else {
        this.isCameraOpen = true;
        this.createCameraElement();
      }
    },

    createCameraElement() {
      this.isLoading = true;

      const constraints = {
        audio: false,
        video: true,
      };

      navigator.mediaDevices
        .getUserMedia(constraints)
        .then((stream) => {
          this.isLoading = false;
          this.$refs.camera.srcObject = stream;
          console.log(this.$refs.camera.srcObject);
        })
        .catch((error) => {
          this.isLoading = false;
          alert("May the browser didn't support or there are some errors.");
        });
    },

    stopCameraStream() {
      let tracks = this.$refs.camera.srcObject.getTracks();

      tracks.forEach((track) => {
        track.stop();
      });
    },

    takePhoto() {
      if (!this.isPhotoTaken) {
        this.isShotPhoto = true;

        const FLASH_TIMEOUT = 50;

        setTimeout(() => {
          this.isShotPhoto = false;
        }, FLASH_TIMEOUT);
      }

      this.isPhotoTaken = !this.isPhotoTaken;

      this.$nextTick(() => {
        const canvas = this.$refs.canvas;
        const context = canvas.getContext("2d");
        context.drawImage(this.$refs.camera, 0, 0, 450, 337.5);
        const dataUrl = canvas.toDataURL("image/png");
        const blob = this.dataURItoBlob(dataUrl);

        const file = new File([blob], "photo.png", { type: "image/png" });
        this.previewImage(file);
        this.toggleCamera();
      });
    },
    dataURItoBlob(dataURI) {
      const byteString = atob(dataURI.split(",")[1]);
      const mimeString = dataURI.split(",")[0].split(":")[1].split(";")[0];
      const ab = new ArrayBuffer(byteString.length);
      const ia = new Uint8Array(ab);

      for (let i = 0; i < byteString.length; i++) {
        ia[i] = byteString.charCodeAt(i);
      }

      return new Blob([ab], { type: mimeString });
    },
    previewImage(file) {
      const reader = new FileReader();

      reader.onload = () => {
        this.previewUrl = reader.result;
      };

      reader.readAsDataURL(file);
    },
    buyTicketForm(ticket) {
      this.selectedTicket = ticket;
    },

    openFileInput() {
      this.$refs.fileInput.click();
    },
    handleFileChange(event) {
      const file = event.target.files[0];

      if (file) {
        this.previewImage(file);
      }
    },

    captureFromCamera() {
      this.$refs.fileInput.click();
    },
  },
};
</script>

<style scoped>
.animate__fadeIn {
  animation: fadeIn 0.5s ease-in-out;
}

@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

.label-text {
  font-size: 13px;
  font-weight: 500;
}

.image-preview {
  margin-top: 20px;
}

.image-preview img {
  max-width: 100%;
  max-height: 300px;
}

.upload-options {
  margin-top: 20px;
}

.upload-options button {
  margin-right: 10px;
  padding: 10px;
}
</style>
