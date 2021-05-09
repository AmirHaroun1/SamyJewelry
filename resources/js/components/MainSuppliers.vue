<template>
    <div>
        <!-------------------- sub nav search suppliers --------------->
        <div class="subheader mt-24 pt-10 pb-10 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Toolbar-->
                <!--begin::Details-->
                <div class="d-flex align-items-center flex-wrap mr-2">

                    <!--begin::Title-->
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">الموردين</h5>
                    <!--end::Title-->
                    <!--begin::Separator-->
                    <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-5 bg-gray-200"></div>
                    <!--end::Separator-->
                    <!--begin::Search Form-->
                    <div class="d-flex align-items-center" id="kt_subheader_search">
                        <form @submit.prevent="SearchSupplierName == '' ? '':SearchEmployees()" class="ml-5">
                            <div class="input-group input-group-sm input-group-solid" style="max-width: 175px">
                                <input type="text" v-model="SearchSupplierName" class="form-control"  placeholder="ابحث عن مورد">
                                <div class="input-group-append">
													<span class="input-group-text" @click="SearchSupplierName == '' ? '':SearchSupplier()">
														<span class="svg-icon cursor-pointer" >
															<!--begin::Svg Icon | path:assets/media/svg/icons/General/Search.svg-->
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																	<rect x="0" y="0" width="24" height="24"></rect>
																	<path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
																	<path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero"></path>
																</g>
															</svg>
                                                            <!--end::Svg Icon-->
														</span>
                                                        <!--<i class="flaticon2-search-1 icon-sm"></i>-->
													</span>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!--end::Search Form-->

                </div>

                <div class="d-flex align-items-center">

                    <!--begin::Button-->
                    <a :href="route('AdminSuppliers.create')"  class="btn btn-light-primary font-weight-bold ml-2">
                        <i class="fa fa-user"></i>
                        اضافة مورد
                    </a>
                    <!--end::Button-->

                </div>
                <!--end::Toolbar-->
            </div>
        </div>
        <!-------------------- ./sub nav search suppliers --------------->
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid pt-10 ">
            <div class="container">
                <!--begin::Delete Search Result Card-->
                <div v-show="SearchedSuppliers.length !=0" @click="ClearSuppliers()" class="card card-custom bg-danger cursor-pointer my-5">
                    <div class="card-header border-0 justify-content-center">
                        <div class="card-title ">
                            <h3 class="card-label text-white ">حذف نتائج البحث</h3>
                            <span class="card-icon">
                                            <i class="flaticon2-chat-1 text-white"></i>
                                        </span>
                        </div>

                    </div>
                </div>
                <!--end::Delete Search Result Card-->
                <!--begin::Main suppliers Card-->
                <div v-show="SearchedSuppliers.length == 0" v-for="supplier in suppliers" :key="supplier.id"  class="card card-custom gutter-b">
                    <suppplier-card :Supplier="supplier"></suppplier-card>
                </div>
                <!--end::Main suppliers Card-->
                <!--begin::search suppliers Card-->
                <div v-show="SearchedSuppliers.length != 0" v-for="supplier in SearchedSuppliers" :key="supplier.id"  class="card card-custom gutter-b">
                    <suppplier-card :Supplier="supplier"></suppplier-card>
                </div>
                <!--end::search suppliers Card-->

            </div>
        </div>
        <!--end::Entry-->

        <loading-spinner v-if="LoadingSpinner"></loading-spinner>
    </div>


</template>

<script>
    export default {
        name: "main-suppliers",
        created () {
            this.FetchSuppliers();
        },
        data(){
            return {
                LoadingSpinner:false,
                SearchSupplierName:'',
                suppliers : [],
                SearchedSuppliers:[],
                FetchPaginationData : {},
                SearchFetchPaginationData: {},
            }
        },
        methods : {
            FetchSuppliers(){
                axios.get(route('api.AdminSuppliers.index'))
                    .then(res=>{
                        if(res.data.suppliers.data.length){
                            this.suppliers = [];
                            this.suppliers.push(...res.data.suppliers.data);
                        }
                        console.log(res);
                        this.FetchPaginationData.current_page = res.data.suppliers.current_page;
                        this.FetchPaginationData.last_page = res.data.suppliers.last_page;
                        this.FetchPaginationData.next_page_url = res.data.suppliers.next_page_url;
                        this.FetchPaginationData.prev_page_url = res.data.suppliers.prev_page_url;
                        this.LoadingSpinner = false;
                    }).catch(error => {
                        console.log(error);
                        this.LoadingSpinner = false;
                        this.$swal({
                            title:'حدث خطأ يرجي اعادة المحاولة',
                            icon:'error',
                        })
                    })
            },
            SearchSupplier(){
                axios.get(route('api.AdminSuppliers.index',{'SupplierName':this.SearchSupplierName}))
                    .then(res=>{
                        if(res.data.suppliers.data.length){
                            this.SearchedSuppliers = [];
                            this.SearchedSuppliers.push(...res.data.suppliers.data);
                        }
                        if(this.SearchedSuppliers.length == 0){
                            this.$swal({
                                title:'لا توجد نتائج للبحث',
                                icon:'warning',
                            })
                        }
                        console.log(res);
                        this.SearchFetchPaginationData.current_page = res.data.suppliers.current_page;
                        this.SearchFetchPaginationData.last_page = res.data.suppliers.last_page;
                        this.SearchFetchPaginationData.next_page_url = res.data.suppliers.next_page_url;
                        this.SearchFetchPaginationData.prev_page_url = res.data.suppliers.prev_page_url;
                        this.LoadingSpinner = false;
                    }).catch(error => {
                    console.log(error);
                    this.LoadingSpinner = false;
                    this.$swal({
                        title:'حدث خطأ يرجي اعادة المحاولة',
                        icon:'error',
                    })
                })
            },
            ClearSuppliers(){
                this.SearchedSuppliers = [];
            }
        }
    }
</script>

<style scoped>

</style>
