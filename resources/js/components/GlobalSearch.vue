
<template>
    <div>
        <div class="w-full">
            <input type="text" class="block w-full p-4 pr-11 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                placeholder="Search Customer Waiver Snapshot" v-model="searchText" @keyup="globalSearchResults" id="custSearchBar" autofocus>
            <button v-if="searchText.length > 0" class="absolute top-0 right-0 h-full p-2 w-10 h-full text-xl dark:text-slate-300 flex items-center justify-center search-modal"
                data-bs-toggle="modal" data-bs-target="#custWavierModal" @click="searchCustWavierSnapShot()">
                <iconify-icon icon="heroicons-solid:search"></iconify-icon>
            </button>
        </div>
        <div class="dropdown-menu z-10 mt-2 absolute hidden bg-white divide-y divide-slate-100 shadow w-full dark:bg-slate-800 border dark:border-slate-700 rounded-md overflow-hidden" id="globalSearchDropDown">
            <ul class="py-1 text-sm text-slate-800 dark:text-slate-200 opacity-1 top-10 divide-y divide-slate-400 dark:divide-slate-700">
                <li v-for="result in results" :key="result.id" class="py-2">
                    <div v-if="result.id && result.id != 0" class="hover:bg-slate-100 dark:hover:bg-slate-600 dark:hover:text-white font-inter text-slate-600 dark:text-white">
                        <a href="javascript:;" @click="searchCustWavierSnapShot(result.id)"
                            data-bs-toggle="modal" data-bs-target="#custWavierModal">
                            <div class="px-4 font-bold text-lg">
                                <p>{{result.value}}</p>
                            </div>
                            <div v-if="result.additional_value" class="px-4 font-normal text-xs">
                                <p>{{ result.additional_value }}</p>
                            </div>
                        </a>
                    </div>
                    <div v-else class="font-inter text-slate-600 dark:text-white">
                        <div class="px-4 font-bold text-lg">
                            <p>{{result.value}}</p>
                        </div>
                        <div v-if="result.additional_value" class="px-4 font-normal text-xs">
                            <p>{{ result.additional_value }}</p>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
import _ from 'lodash';

export default {
    props: [],
    data() {
      return {
        results: [],
        searchText: '',
      };
    },
    created() {
        this.globalSearchResults = _.debounce(this.globalSearchResults, 500, {
            leading: false,
            trailing: true,
        })
    },
    methods: {
        clearResults(){
            this.results = [];
            var element = document.getElementById("globalSearchDropDown");
            element.classList.add("hidden");
        },

        async globalSearchResults(){
            this.clearResults();
            try{
                if(this.searchText.length > 0){
                    const response = await axios.get('/global-search',{
                        params: {
                            module : 'Customer',
                            search: this.searchText
                        }
                    });
                    if(Array.isArray(response.data) && response.data.length > 0)
                        this.results = response.data;
                    else
                        this.results = [{id: 0, value: 'No Result Found'}];
                    var element = document.getElementById("globalSearchDropDown");
                    element.classList.remove("hidden");
                }
            }catch(error){
                console.log(error);
            }
        },

        async searchCustWavierSnapShot(id = null){
            document.getElementById('custWavierModalContent').innerHTML = '';
            let imageUrl = window.location.origin + "/images/funvilla.png"
            $.LoadingOverlay('show', {
                image       : imageUrl,
                imageAnimation  : "1.5s fadein",
            });
            if(this.searchText){
                let form = {
                    module: 'Customer',
                    q:  this.searchText
                };

                if(id)
                    form['id'] = id;

                await axios.get('/customer-wavier-snapshot', {
                    params: form
                })
                .then(response => {
                    if(response.data?.status && response.data?.data){
                        this.clearResults();
                        this.searchText = '';
                        document.getElementById('custWavierModalContent').innerHTML = response.data?.data;
                    }
                    $.LoadingOverlay('hide');
                })
                .catch(error => {
                    console.log(error);
                    $.LoadingOverlay('hide');
                });
            } 
            else
                $.LoadingOverlay('hide');
        }
    },
};

</script>

<style>
</style>