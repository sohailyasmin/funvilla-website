<template>
  <div>
    <div
      class="modal"
      :class="{ show: showModal }"
      id="exampleModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
      @click="closeModal"
    >
      <div
        class="modal-dialog modal-dialog-centered modal-lg"
        role="document"
        @click.stop
      >
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
              Funvilla Locations
            </h5>
            <button
              type="button"
              class="close modal-close"
              @click="closeModal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body funvilla-locations">
            <div class="row">
              <div class="col-md-4 text-center">
                <input type="radio" name="test" id="cb1" />
                <label for="cb1"
                  ><img src="https://funvilla.ca/images/locations/barrie.jpg"
                /></label>
                <b>Brie</b>
              </div>
              <div class="col-md-4 text-center">
                <input type="radio" name="test" id="cb2" />
                <label for="cb2"
                  ><img src="https://funvilla.ca/images/locations/barrie.jpg"
                /></label>
                <b>Brie</b>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <a href="#" class="custom-button"
              ><span class="circle" aria-hidden="true"
                ><span class="icon arrow"></span
              ></span>
              <span class="button-text">Confirm Location</span></a
            >
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted, watch } from "vue";
import { gsap } from "gsap";

export default {
  setup() {
    const showModal = ref(false);
    const modalRef = ref(null);
    watch(showModal, (newVal) => {
      if (newVal) {
        gsap.to(modalRef.value, {
          opacity: 1,
          scale: 1,
          duration: 0.5,
          ease: "power2.out",
        });
      } else {
        gsap.to(modalRef.value, {
          opacity: 0,
          scale: 0.8,
          duration: 0.3,
          ease: "power2.in",
        });
      }
    });
    const openModal = () => {
      showModal.value = true;
    };

    const closeModal = (event) => {
      showModal.value = false;
    };

    onMounted(() => {
      openModal();
    });

    return {
      showModal,
      openModal,
      closeModal,
    };
  },
};
</script>

<style>
.modal {
  display: none;
  background-color: rgba(0, 0, 0, 0.5);
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  z-index: 1050;
  overflow: hidden;
}

.modal.show {
  display: block;
}

.funvilla-locations input[type="radio"][id^="cb"] {
  display: none;
}

.funvilla-locations label {
  display: block;
  position: relative;
  margin: 10px;
  cursor: pointer;
}

.funvilla-locations label:before {
  background-color: white;
  color: white;
  content: " ";
  display: block;
  border-radius: 50%;
  border: 1px solid grey;
  position: absolute;
  top: -5px;
  left: -5px;
  width: 25px;
  height: 25px;
  text-align: center;
  line-height: 28px;
  transition-duration: 0.4s;
  transform: scale(0);
}

.funvilla-locations label img {
  transition-duration: 0.2s;
  transform-origin: 50% 50%;
}

.funvilla-locations :checked + label {
  box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px;
}

.funvilla-locations :checked + label:before {
  content: "✓";
  background-color: grey;
  transform: scale(1);
  z-index: 1;
}

.funvilla-locations :checked + label img {
  transform: scale(0.9);
  box-shadow: 0 0 5px #333;
  z-index: -1;
}
</style>
