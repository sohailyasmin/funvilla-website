<template>
    <div>  
        <div class="card md:col-span-2">
            <div class="card-body flex flex-col p-4 md:p-6 lg:p-8">
                <header class="flex mb-2 items-center border-b border-slate-100 dark:border-slate-700 pb-2 -mx-4 px-4">
                    <div class="flex-1">
                        <div class="card-title text-slate-900 dark:text-white">Terms And Condition</div>
                    </div>
                </header>
                <div class="card-text">
                    <form class="space-y-4" @submit.prevent="submitForm">
                      <div class="input-area">
                        <label for="title" class="form-label">Title</label>
                        <input class="form-control"
                               placeholder="Enter Title" v-model="title">
                      </div>
                      <div v-if="Object.keys(errors).indexOf('title') != '-1'">
                        <div class="mt-4 font-bold text-red-600">{{  Array.isArray(errors['title']) ? errors['title'][0] : errors['title'] }}</div>
                      </div>
                      <div class="input-area">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" type="text" id="description" class="form-control"
                               placeholder="Enter Description" v-model="description">
                        </textarea>
                      </div>

                        <editor
                            :tinymce-script-src=path 
                            :init="{
                                height: 500,
                                plugins: [
                                    'advlist autolink lists link image charmap print preview anchor',
                                    'searchreplace visualblocks code fullscreen',
                                    'insertdatetime media table paste code help wordcount'
                                ],
                            }"
                            v-model="text"
                        />
                        <div v-if="Object.keys(errors).indexOf('text') != '-1'">
                            <div class="mt-4 font-bold text-red-600">{{  Array.isArray(errors['text']) ? errors['text'][0] : errors['text'] }}</div>
                        </div>
                        <div class="input-area">
                            <label for="location_id" class="form-label">Location</label>
                            <select name="location_id" id="location_id" class="form-control" v-model="location_id" required>
                                <option value="" selected disabled>
                                    Select Location
                                </option>
                                <option v-for="option in locations" :value="option.id">
                                    {{ option.name }}
                                </option>
                            </select>
                        </div>
                        <div v-if="Object.keys(errors).indexOf('location_id') != '-1'">
                            <div class="mt-4 font-bold text-red-600">{{  Array.isArray(errors['location_id']) ? errors['location_id'][0] : errors['location_id'] }}</div>
                        </div>
                        <div class="flex items-center dark:text-white mt-4 mb-4">
                            <input id="terms-and-condition-is-default-checkbox" type="checkbox" v-model="isDefault" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="terms-and-condition-is-default-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Is Default Terms and Conditions?</label>
                        </div>
                        <div v-if="Object.keys(errors).indexOf('is_default') != '-1'">
                            <div class="mt-4 font-bold text-red-600">{{  Array.isArray(errors['is_default']) ? errors['is_default'][0] : errors['is_default'] }}</div>
                        </div>

                        <button type="submit" class="btn inline-flex justify-center btn-dark mt-4 w-full">
                            Submit
                        </button>
                    </form>
                </div>
            </div>
        </div>        
    </div>
</template>
<script>
export default {
    props: ['path', 'tcText', 'tcIsDefault', 'termsAndConditionId', 'locations', 'tcTitle', 'tcDescription', 'locationId'],
    data() {
      return {
        text: this.tcText,
        location_id: this.locationId,
        isDefault: this.tcIsDefault == 1 ? true : false,
        errors: {},
        title: this.tcTitle,
        description: this.tcDescription,
      };
    },
    mounted(){

    },
    methods: {
        async submitForm(){
            let imageUrl = window.location.origin + "/images/funvilla.png"
            $.LoadingOverlay('show', {
                image       : imageUrl,
                imageAnimation  : "1.5s fadein",
            });
            this.errors = {};
            try{
                let validate = false;
                if(!validate){
                    let form = {
                        text: this.text,
                        location_id: this.location_id,
                        is_default: this.isDefault,
                        title: this.title,
                      description: this.description,
                    };
                    let method = 'post';
                    let url = `/terms-condition`;

                    if(this.termsAndConditionId){
                        method = 'put';
                        url = `/terms-condition/${this.termsAndConditionId}`;
                    }
                    console.log(form)
                    await axios({method: method, url: url, data: form})
                    .then(response => {
                        if(response.data.status){
                            window.location.href = "/"+response.data.href;
                        }
                    })
                    .catch(error => {
                        const statusCode = error.response?.status;
                        const errorsList = error.response?.data?.errors;
                        if(statusCode == 422 && errorsList){
                            this.errors = errorsList;
                        }   
                        $.LoadingOverlay('hide');
                    });   
                }
                if(Object.keys(this.errors).length > 0){
                    let position =  $("#"+Object.keys(this.errors)[0]).offset().top - 105;
                    $('html, body').animate({ 
                        scrollTop: position
                    }, 600);
                }
            }
            catch(e){
                console.log(e);
            }
            
            $.LoadingOverlay('hide');
        }
    },
};
</script>