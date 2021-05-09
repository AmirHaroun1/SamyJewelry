<template>
    <div>
        <!-------------------- sub nav search users --------------->
        <div class="subheader mt-24 pt-10 pb-10 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Toolbar-->
                <!--begin::Details-->
                <div class="d-flex align-items-center flex-wrap mr-2">


                    <!--begin::Title-->
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">الموظفين</h5>
                    <!--end::Title-->
                    <!--begin::Separator-->
                    <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-5 bg-gray-200"></div>
                    <!--end::Separator-->
                    <!--begin::Search Form-->
                    <div class="d-flex align-items-center" id="kt_subheader_search">
                        <form @submit.prevent="SearchEmployeeName == '' ? '':SearchEmployees()" class="ml-5">
                            <div class="input-group input-group-sm input-group-solid" style="max-width: 175px">
                                <input type="text" v-model="SearchEmployeeName" class="form-control"  placeholder="ابحث عن موظف">
                                <div class="input-group-append">
													<span class="input-group-text" @click="SearchEmployeeName == '' ? '':SearchEmployees()">
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
                <!--end::Details-->
                <div class="d-flex align-items-center">

                    <!--begin::Button-->
                    <a :href="route('AdminEmployees.create')"  class="btn btn-light-primary font-weight-bold ml-2">
                       <i class="fa fa-user"></i>
                        اضافة موظف
                    </a>
                    <!--end::Button-->

                </div>
                <!--end::Toolbar-->

            </div>
        </div>
        <!-------------------- ./sub nav search users --------------->
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid pt-10 ">
            <div class="container">

                <!--begin::Delete Search Result Card-->
                <div v-show="SearchedEmployees.length !=0" @click="ClearEmployees()" class="card card-custom bg-danger cursor-pointer">
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

                <!--begin::Main Employees Card-->
                <div v-show="SearchedEmployees.length == 0" v-for="(employee,index) in employees" :key="employee.id"  class="card card-custom gutter-b">
                    <employee-stats-card :employee="employee" ></employee-stats-card>
                </div>
                <!--end::Main Employees Card-->

                <!--begin::Search-Card-->
                <div v-show="SearchedEmployees.length != 0" v-for="employee in SearchedEmployees" :key="employee.id"  class="card card-custom gutter-b">
                    <employee-stats-card :employee="employee" ></employee-stats-card>
                </div>
                <!--end::Search-Card-->
                <div v-show="!SearchedEmployees.length" class="card card-custom">
                    <div class="card-body py-7">
                        <!--begin::Pagination-->
                        <div class="d-flex justify-content-center align-items-center text-center  flex-wrap">
                            <div class="d-flex flex-wrap mr-3">
                                <a @click="FetchEmployees(FetchPaginationData.current_page - 1)" v-if="FetchPaginationData.prev_page_url" class="btn btn-icon btn-sm btn-light-primary mr-2 my-1">
                                    <i class="ki ki-bold-arrow-back icon-xs"></i>
                                </a>

                                <a href="#" class="btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1">
                                    صفحة

                                    {{FetchPaginationData.current_page}}
                                        من
                                    {{FetchPaginationData.last_page}}
                                </a>

                                <a @click="FetchEmployees(FetchPaginationData.current_page + 1)" v-if="FetchPaginationData.next_page_url" class="btn btn-icon btn-sm btn-light-primary mr-2 my-1">
                                    <i class="ki ki-bold-arrow-next icon-xs"></i>
                                </a>
                            </div>

                        </div>

                        <!--end:: Pagination-->
                    </div>
                </div>
            </div>
        </div>
        <!--end::Entry-->
        <loading-spinner v-if="LoadingSpinner"></loading-spinner>

    </div>
</template>

<script>
    export default {
        name: "MainِEmployees",

        created() {
            this.FetchEmployees();
        },
        data() {
            return {
                'LoadingSpinner':false,
                'employees':[],
                'SearchedEmployees':[],
                'SearchEmployeeName':'',
                FetchPaginationData: {
                    'current_page': '',
                    'last_page': '',
                    'next_page_url': '',
                    'prev_page_url': '',
                },
            }
        },
        methods:{
            FetchEmployees(page = 1){
                this.LoadingSpinner = true;
                axios.get(route('api.AdminEmployees.index',{'page':page,'withPagination':true}))
                    .then((res) => {
                        if(res.data.employees.data.length){
                            this.employees = [];
                            this.employees.push(...res.data.employees.data);
                        }
                        this.FetchPaginationData.current_page = res.data.employees.current_page;
                        this.FetchPaginationData.last_page = res.data.employees.last_page;
                        this.FetchPaginationData.next_page_url = res.data.employees.next_page_url;
                        this.FetchPaginationData.prev_page_url = res.data.employees.prev_page_url;
                        this.LoadingSpinner = false;
                    }).catch(error => {
                        console.log(error);
                        this.LoadingSpinner = true;
                        this.$swal({
                                title:'حدث خطأ يرجي اعادة المحاولة',
                                icon:'error',
                            })
                    })
            },
            SearchEmployees(){
                this.LoadingSpinner = true;
                this.SearchedEmployees = [];
                axios.get(route('api.AdminEmployees.search',{'EmployeeName':this.SearchEmployeeName}))
                    .then(({data}) => {
                        console.log(data);
                        this.SearchedEmployees.push(...data.SearchedEmployees)
                        this.LoadingSpinner = false;
                        if(this.SearchedEmployees.length == 0){
                            this.$swal({
                                title:'لا توجد نتائج للبحث',
                                icon:'warning',
                            })
                        }
                    }).catch(error => {
                        this.LoadingSpinner = false;
                        console.log(error);
                            this.$swal({
                                title:'حدث خطأ يرجي اعادة المحاولة',
                                icon:'error',
                            })
                    })
            },
            ClearEmployees(){
                this.SearchedEmployees = [];
                this.FetchEmployees();
            }
        }
    }
</script>

<style scoped>

</style>
