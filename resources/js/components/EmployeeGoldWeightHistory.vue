<template>
    <div>
        <div class="  py-3">
            <div class="xl-8">
                <!------ begin: Add Weight For Normal --------->
                <div class="border-bottom">
                    <h4 class=" font-weight-bold text-dark py-2 ">اضافة وزنة</h4>
                    <form @submit.prevent="UpdateEmployeeGoldWeight(false)" id="AddWightForm">
                        <div class="row">
                            <div class="col-xl-4">
                                <label>العدد : {{Employee.number_of_items}}</label>
                                <input type="number" class="form-control" step="0.01" v-model="AddedNumberOfItems">
                            </div>
                            <div class="col-xl-4">
                                <label>الوزنة عيار ١٨ : {{Employee.current_weight_18}}</label>
                                <input type="number" class="form-control" step="0.01" v-model="Added_weight_18">
                            </div>
                            <div class="col-xl-4">
                                <label>الوزنة عيار ٢١ : {{Employee.current_weight_21}}</label>
                                <input type="number" class="form-control" step="0.01" v-model="Added_weight_21">
                            </div>
                            <div class="col-xl-12 text-center my-8 ">
                                <button form="AddWightForm" class="btn btn-primary btn-md">اضافة وزنة</button>
                            </div>

                        </div>
                    </form>
                </div>
                <!------ end: Add Weight For Normal --------->
                <!------ begin: Add Weight For Bracelet --------->
                <div class="border-bottom" v-if="Employee.id == 1">
                    <h4 class=" font-weight-bold text-dark py-2 ">اضافة الغوايش</h4>
                    <form @submit.prevent="UpdateEmployeeGoldWeight(true)" id="AddWightForBraceletForm">
                        <div class="row">
                            <div class="col-xl-4">
                                <label>العدد : {{Employee.bracelets_number_of_items}}</label>
                                <input type="number" class="form-control" step="0.01" v-model="Bracelet_AddedNumberOfItems">
                            </div>
                            <div class="col-xl-4">
                                <label>الوزنة عيار ١٨ : {{Employee.bracelets_current_weight_18}}</label>
                                <input type="number" class="form-control" step="0.01" v-model="Bracelet_Added_weight_18">
                            </div>
                            <div class="col-xl-4">
                                <label>الوزنة عيار ٢١ : {{Employee.bracelets_current_weight_21}}</label>
                                <input type="number" class="form-control" step="0.01" v-model="Bracelet_Added_weight_21">
                            </div>
                            <div class="col-xl-12 text-center my-8  ">
                                <button form="AddWightForBraceletForm" class="btn btn-primary btn-md">اضافة وزنة</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!------ end: Add Weight For Bracelet --------->

            </div>
        </div>
        <!--begin::Employee Gold History-->
        <h4 class="mb-10 font-weight-bold text-dark py-3">تاريخ وزنة {{Employee.name}}</h4>
        <div class="py-4 justify-content-center">
            <div class="card card-custom bg-success">
                <div class="card-header border-0">
                    <div class="card-title">
                        <h3 class="card-label text-white">
                            بحث بالتاريخ :
                        </h3>
                        <span class="card-icon">
                            <i class="flaticon-search text-white"></i>
                        </span>
                    </div>
                </div>

                <form class="card-body row text-white justify-content-center" @submit.prevent="date != '' ? SearchEmployeeGoldHistory():''">
                    <VueCtkDateTimePicker :maxDate="maxDate"  :format="'YYYY-MM-DD '" :formatted="'YYYY-MM-DD'" label="أختر التاريخ" v-model="date"></VueCtkDateTimePicker>
                    <button class="btn bg-white my-4">بحث</button>
                </form>
            </div>
        </div>
        <div v-if="GoldHistory.length != 0 && SearchedGoldHistory.length == 0" >
            <div v-for="transaction in GoldHistory">

                <!--begin:: weight card-->
                <div :class="parseFloat(transaction.weight_amount) > 0 ? (transaction.sold != 1 ? 'card card-custom gutter-b bg-light-primary' : 'card card-custom gutter-b bg-light-success' ) : 'card card-custom gutter-b bg-light-danger'">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between p-4 flex-lg-wrap flex-xl-nowrap">
                            <div class="d-flex flex-column mr-5">

                                <a v-if="transaction.sold == 1" class="h4 text-dark text-hover-primary mb-5">
                                     فاتورة :
                                    بمقدار
                                    <b>{{Math.abs(parseFloat(transaction.weight_amount))}}
                                    جرام
                                    </b>
                                    لتصبح الوزنة
                                    <b>
                                        {{parseFloat(transaction.original_weight) - parseFloat(transaction.weight_amount)}}
                                        جرام
                                    </b>

                                    عيار{{transaction.weight_type}}
                                </a>
                                <a v-else-if="parseFloat(transaction.weight_amount) > 0" class="h4 text-dark text-hover-primary mb-5">
                                     اضافة
                                    بمقدار
                                    <b>{{Math.abs(parseFloat(transaction.weight_amount))}}
                                        جرام
                                    </b>
                                    لتصبح الوزنة
                                    <b>{{parseFloat(transaction.weight_amount) + parseFloat(transaction.original_weight)}}
                                        جرام
                                    </b>
                                    عيار{{transaction.weight_type}}

                                </a>
                                <a v-else class="h4 text-dark text-hover-danger mb-5">
                                    تنقيص
                                    بمقدار
                                    <b>{{Math.abs(parseFloat(transaction.weight_amount))}}
                                        جرام
                                    </b>
                                    لتصبح الوزنة
                                    <b>{{parseFloat(transaction.weight_amount) + parseFloat(transaction.original_weight)}}
                                        جرام
                                    </b>
                                    عيار{{transaction.weight_type}}

                                    <br>
                                </a>

                                <a class="h5 text-dark text-hover-danger my-5">
                                    الوزن الأصلى :
                                    {{parseFloat(transaction.original_weight)}}
                                </a><a class="h5 text-dark text-hover-danger my-5">
                                    التاريخ :
                                    {{format_date(transaction.created_at)}}
                                </a>
                            </div>
                            <div class="ml-6 ml-lg-0 ml-xxl-6 flex-shrink-0">
                                <a v-if="transaction.sold == 1" class="btn font-weight-bolder text-uppercase btn-success py-4 px-6">
                                    <b v-if="transaction.is_bracelet">فاتورة - غويشة</b>
                                    <b v-else>فاتورة</b>
                                </a>
                                <a v-else-if="parseFloat(transaction.weight_amount) > 0" class="btn font-weight-bolder text-uppercase btn-primary py-4 px-6" >
                                    <b v-if="transaction.is_bracelet">زيادة - غويشة</b>
                                    <b v-else>زيادة</b>
                                </a>
                                <a  v-else-if="parseFloat(transaction.weight_amount) < 0" class="btn font-weight-bolder text-uppercase btn-danger py-4 px-6">
                                    <b v-if="transaction.is_bracelet">نقص - غويشة</b>
                                    <b v-else>نقص</b>
                                </a>

                            </div>
                        </div>
                    </div>
                </div>
                <!--end::weight card-->


            </div>
            <div class="card-body py-7">
                <!--begin::Pagination-->
                <div class="d-flex justify-content-center align-items-center text-center  flex-wrap">
                    <div class="d-flex flex-wrap mr-3">
                        <a @click="FetchEmployeeGoldHistory(FetchPaginationData.current_page + 1)" v-if="FetchPaginationData.next_page_url" class="btn btn-icon btn-sm btn-light-primary mr-2 my-1">
                            <i class="ki ki-bold-arrow-next icon-xs"></i>
                        </a>


                        <a href="#" class="btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1">
                            صفحة

                            {{FetchPaginationData.current_page}}
                            من
                            {{FetchPaginationData.last_page}}
                        </a>

                        <a @click="FetchEmployeeGoldHistory(FetchPaginationData.current_page-1)" v-if="FetchPaginationData.prev_page_url" class="btn btn-icon btn-sm btn-light-primary mr-2 my-1">
                            <i class="ki ki-bold-arrow-back icon-xs"></i>
                        </a>
                    </div>

                </div>
                <!--end:: Pagination-->
            </div>
        </div>
        <!--end::Employee Gold History-->
        <!--begin::Employee search Gold History-->
        <div v-if="SearchedGoldHistory.length != 0" >

            <!--begin::Delete Search Result Card-->
            <div v-show="SearchedGoldHistory.length !=0" @click="SearchedGoldHistory = []" class="card card-custom bg-danger cursor-pointer">
                <div class="card-header border-0 justify-content-center">
                    <div class="card-title ">
                                        <span class="card-icon">
                                            <i class="flaticon2-delete text-white"></i>
                                        </span>
                        <h3 class="card-label text-white ">حذف نتائج البحث</h3>
                    </div>

                </div>
            </div>
            <!--end::Delete Search Result Card-->

            <div class="py-5" v-for="transaction in SearchedGoldHistory">
                <!--begin:: weight card-->
                <div :class="parseFloat(transaction.weight_amount) > 0 ? (transaction.sold != 1 ? 'card card-custom gutter-b bg-light-primary' : 'card card-custom gutter-b bg-light-success' ) : 'card card-custom gutter-b bg-light-danger'">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between p-4 flex-lg-wrap flex-xl-nowrap">
                            <div class="d-flex flex-column mr-5">

                                <a v-if="transaction.sold == 1" class="h4 text-dark text-hover-primary mb-5">
                                    فاتورة :
                                    بمقدار
                                    <b>{{Math.abs(parseFloat(transaction.weight_amount))}}
                                        جرام
                                    </b>
                                    لتصبح الوزنة
                                    <b>
                                        {{parseFloat(transaction.original_weight) - parseFloat(transaction.weight_amount)}}
                                        جرام
                                    </b>
                                    عيار{{transaction.weight_type}}

                                </a>
                                <a v-else-if="parseFloat(transaction.weight_amount) > 0" class="h4 text-dark text-hover-primary mb-5">
                                    اضافة
                                    بمقدار
                                    <b>{{Math.abs(parseFloat(transaction.weight_amount))}}
                                        جرام
                                    </b>
                                    لتصبح الوزنة
                                    <b>{{parseFloat(transaction.weight_amount) + parseFloat(transaction.original_weight)}}
                                        جرام
                                    </b>
                                    عيار{{transaction.weight_type}}

                                </a>
                                <a v-else class="h4 text-dark text-hover-danger mb-5">
                                    تنقيص
                                    بمقدار
                                    <b>{{Math.abs(parseFloat(transaction.weight_amount))}}
                                        جرام
                                    </b>
                                    لتصبح الوزنة
                                    <b>{{parseFloat(transaction.weight_amount) + parseFloat(transaction.original_weight)}}
                                        جرام
                                    </b>
                                    عيار{{transaction.weight_type}}

                                    <br>
                                </a>

                                <a class="h5 text-dark text-hover-danger my-5">
                                    الوزن الأصلى :
                                    {{parseFloat(transaction.original_weight)}}
                                </a><a class="h5 text-dark text-hover-danger my-5">
                                التاريخ :
                                {{format_date(transaction.created_at)}}
                            </a>
                            </div>
                            <div class="ml-6 ml-lg-0 ml-xxl-6 flex-shrink-0">
                                <a v-if="transaction.sold == 1" class="btn font-weight-bolder text-uppercase btn-success py-4 px-6">
                                    <b>فاتورة</b>
                                </a>
                                <a v-else-if="parseFloat(transaction.weight_amount) > 0" class="btn font-weight-bolder text-uppercase btn-primary py-4 px-6" >
                                    <b>زيادة</b>
                                </a>
                                <a  v-else-if="parseFloat(transaction.weight_amount) < 0" class="btn font-weight-bolder text-uppercase btn-danger py-4 px-6">
                                    <b>نقص</b>
                                </a>

                            </div>
                        </div>
                    </div>
                </div>
                <!--end::weight card-->
            </div>
            <div class="card-body py-7">
                <!--begin::Pagination-->
                <div class="d-flex justify-content-center align-items-center text-center  flex-wrap">
                    <div class="d-flex flex-wrap mr-3">
                        <a @click="SearchEmployeeGoldHistory(SearchedPaginationData.current_page + 1)" v-if="SearchedPaginationData.next_page_url" class="btn btn-icon btn-sm btn-light-primary mr-2 my-1">
                            <i class="ki ki-bold-arrow-next icon-xs"></i>
                        </a>


                        <a href="#" class="btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1">
                            صفحة

                            {{SearchedPaginationData.current_page}}
                            من
                            {{SearchedPaginationData.last_page}}
                        </a>

                        <a @click="SearchEmployeeGoldHistory(SearchedPaginationData.current_page-1)" v-if="SearchedPaginationData.prev_page_url" class="btn btn-icon btn-sm btn-light-primary mr-2 my-1">
                            <i class="ki ki-bold-arrow-back icon-xs"></i>
                        </a>
                    </div>

                </div>
                <!--end:: Pagination-->
            </div>
        </div>
        <!--end::Employee search Gold History-->
        <loading-spinner v-if="LoadingSpinner"></loading-spinner>
    </div>
</template>

<script>

    export default {
        name: "EmployeeGoldWeightHistory",
        props:{
            'Employee':{},
        },
        data (){
            return {
                LoadingSpinner : false,
                'AddedNumberOfItems':0 ,
                'Bracelet_AddedNumberOfItems':0 ,
                'Added_weight_21':0 ,
                'Added_weight_18':0 ,
                'Bracelet_Added_weight_21':0 ,
                'Bracelet_Added_weight_18':0 ,
                'temp_employee':{},
                'ComparingDate':null,
                'GoldHistory':[],
                'SearchedGoldHistory':[],
                FetchPaginationData: {
                    'current_page': '',
                    'last_page': '',
                    'next_page_url': '',
                    'prev_page_url': '',
                },
                SearchedPaginationData: {
                    'current_page': '',
                    'last_page': '',
                    'next_page_url': '',
                    'prev_page_url': '',
                },
                date: '',
                maxDate:moment().toString(),
                has18weight : false,
                has21weight : false,
                Bracelet_has18weight : false,
                Bracelet_has21weight : false,
            }
        },
        created () {
            this.FetchEmployeeGoldHistory(1);
        },
        methods:{
            FetchEmployeeGoldHistory(page = 1){
                this.LoadingSpinner = true;
                axios.get(route('api.AdminEmployees.WeightHistory',{'employeeID':this.Employee.id,'page':page}))
                    .then(({data}) => {
                        this.GoldHistory = [];
                        this.GoldHistory.push(...data.GoldTransactionHistory.data);
                        this.FetchPaginationData.current_page = data.GoldTransactionHistory.current_page;
                        this.FetchPaginationData.last_page = data.GoldTransactionHistory.last_page;
                        this.FetchPaginationData.next_page_url = data.GoldTransactionHistory.next_page_url;
                        this.FetchPaginationData.prev_page_url = data.GoldTransactionHistory.prev_page_url;
                        console.log(data);
                       this.LoadingSpinner = false;

                    }).catch(error => {
                        console.log(error);
                       this.LoadingSpinner = false;

                })
            },
            UpdateEmployeeGoldWeight(ForBracelets){
                this.LoadingSpinner = true;
                let formData = new FormData();
                this.has18weight = false;
                this.has21weight = false;
                this.Bracelet_has18weight = false;
                this.Bracelet_has21weight = false;
                formData.append('_method',"PATCH");
                if(!ForBracelets){
                    if( this.AddedNumberOfItems != '' && this.AddedNumberOfItems != 0){
                        formData.append('number_of_items',this.AddedNumberOfItems);
                    }
                    if( this.Added_weight_18 != '' && this.Added_weight_18 != 0){
                        this.has18weight = true;
                        formData.append('weight_change','add_weight');
                        formData.append('current_weight_18',this.Added_weight_18);
                    }
                    if( this.Added_weight_21 != '' && this.Added_weight_21 != 0){
                        this.has21weight = true;
                        formData.append('weight_change','add_weight');
                        formData.append('current_weight_21',this.Added_weight_21);
                    }
                }else{
                    formData.append('bracelets_change',1);
                    formData.append('weight_change','add_weight');
                    if( this.Bracelet_AddedNumberOfItems != '' && this.Bracelet_AddedNumberOfItems != 0){
                        formData.append('bracelets_number_of_items',this.Bracelet_AddedNumberOfItems);
                    }
                    if( this.Bracelet_Added_weight_18 != '' && this.Bracelet_Added_weight_18 != 0){
                        this.Bracelet_has18weight = true;
                        formData.append('bracelets_current_weight_18',this.Bracelet_Added_weight_18);
                    }
                    if( this.Bracelet_Added_weight_21 != '' && this.Bracelet_Added_weight_21 != 0){
                        this.Bracelet_has21weight = true;
                        formData.append('bracelets_current_weight_21',this.Bracelet_Added_weight_21);
                    }
                }
                axios.post(route('AdminEmployees.update',this.Employee.id),formData)
                    .then(res => {
                        this.LoadingSpinner = false;
                        this.$swal({
                            icon:'success',
                            title:'تم اضافة وزنة بنجاح',
                            showConfirmButton: false,
                            timer: 1000
                        })
                        this.AddTransactionToGoldHistory(ForBracelets);
                        for (const property in this.Employee) {
                            this.temp_employee[property] = this.Employee[property];
                        }
                        this.$emit('EmployeeDataChanged',this.temp_employee,true);
                    }).catch((error) => {
                            alert(error);
                            console.log(error);
                            this.LoadingSpinner = false;
                            this.$swal({
                                title:'حدث خطأ تأكد من البيانات',
                                icon:'error',
                            })
                        })
            },
            AddTransactionToGoldHistory(ForBracelets){
                if(!ForBracelets){
                    this.Employee.number_of_items = parseInt(this.Employee.number_of_items) + parseInt(this.AddedNumberOfItems);
                    this.AddedNumberOfItems = 0;
                    if(this.has18weight){
                        if (!this.Employee.hasOwnProperty('current_weight_18') || this.Employee.current_weight_18 == ''){
                            this.Employee.current_weight_18 = 0;
                        }
                        this.GoldHistory.unshift({'original_weight':this.Employee.current_weight_18,'weight_amount':this.Added_weight_18,'weight_type':'18','created_at':moment()});
                        this.Employee.current_weight_18 = parseFloat( this.Employee.current_weight_18) + parseFloat( this.Added_weight_18 );
                        this.Added_weight_18 = 0;
                    }if(this.has21weight){
                        if (!this.Employee.hasOwnProperty('current_weight_21') || this.Employee.current_weight_21 == ''){
                            this.Employee.current_weight_21 = 0;
                        }
                        this.GoldHistory.unshift({'original_weight':this.Employee.current_weight_21,'weight_amount':this.Added_weight_21,'weight_type':'21','created_at':moment()});
                        this.Employee.current_weight_21 = parseFloat( this.Employee.current_weight_21) + parseFloat( this.Added_weight_21 );
                        this.Added_weight_21 = 0;
                    }
                }else{
                    this.Employee.bracelets_number_of_items = parseInt(this.Employee.bracelets_number_of_items) + parseInt(this.Bracelet_AddedNumberOfItems);
                    this.Bracelet_AddedNumberOfItems = 0;
                    if(this.Bracelet_has18weight){
                        if (!this.Employee.hasOwnProperty('bracelets_current_weight_18') || this.Employee.bracelets_current_weight_18 == ''){
                            this.Employee.bracelets_current_weight_18 = 0;
                        }
                        this.GoldHistory.unshift({'is_bracelet':true,'original_weight':this.Employee.bracelets_current_weight_18,'weight_amount':this.Bracelet_Added_weight_18,'weight_type':'18','created_at':moment()});
                        this.Employee.bracelets_current_weight_18 = parseFloat( this.Employee.bracelets_current_weight_18) + parseFloat( this.Bracelet_Added_weight_18 );
                        this.Bracelet_Added_weight_18 = 0;
                    }
                    if(this.Bracelet_has21weight){
                        if (!this.Employee.hasOwnProperty('bracelets_current_weight_21') || this.Employee.bracelets_current_weight_21 == ''){
                            this.Employee.bracelets_current_weight_21 = 0;
                        }
                        this.GoldHistory.unshift({'is_bracelet':true,'original_weight':this.Employee.bracelets_current_weight_21,'weight_amount':this.Bracelet_Added_weight_21,'weight_type':'21','created_at':moment()});
                        this.Employee.bracelets_current_weight_21 = parseFloat( this.Employee.bracelets_current_weight_21) + parseFloat( this.Bracelet_Added_weight_21 );
                        this.Bracelet_Added_weight_21 = 0;
                    }
                }

            },
            format_date(date){
                if (date) {
                    return moment(String(date)).format('DD/MM/YYYY HH:mm')
                }
            },
            SearchEmployeeGoldHistory(page = 1){
                this.LoadingSpinner = true;
                this.SearchedGoldHistory = [];
                axios.get(route('api.AdminEmployees.WeightHistory.search',{'page':page,'employeeID':this.Employee.id,'ComparingDate':this.date}))
                    .then(({data}) => {
                        this.LoadingSpinner = false;

                        console.log(data);
                        this.SearchedGoldHistory.push(...data.SearchedEmployeeGoldHistory.data);
                        this.SearchedPaginationData.current_page = data.SearchedEmployeeGoldHistory.current_page;
                        this.SearchedPaginationData.last_page = data.SearchedEmployeeGoldHistory.last_page;
                        this.SearchedPaginationData.next_page_url = data.SearchedEmployeeGoldHistory.next_page_url;
                        this.SearchedPaginationData.prev_page_url = data.SearchedEmployeeGoldHistory.prev_page_url;
                        if(this.SearchedGoldHistory.length == 0){
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
        }
    }
</script>

<style scoped>

</style>
