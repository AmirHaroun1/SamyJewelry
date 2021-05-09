<template>
    <div class="col-md-12">

        <!--begin::Search Start Date End Date-->
        <div class="py-4">
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
                <div>
                    <form class="card-body row text-white" id="SearchByTimeForm" @submit.prevent="SearchEmployeeInvoices(1)">
                        <div class="col-md-6">
                                <label>تاريخ بداية المدة</label>
                                <VueCtkDateTimePicker :maxDate="maxDate"  :format="'YYYY-MM-DD H:mm '" :formatted="'YYYY-MM-DD H:mm'" label="أختر تاريخ البداية" v-model="StartDate"></VueCtkDateTimePicker>
                        </div>
                        <div class="col-md-6">
                                <label>تاريخ نهاية المدة</label>
                                <VueCtkDateTimePicker :maxDate="maxDate"  :format="'YYYY-MM-DD H:mm '" :formatted="'YYYY-MM-DD H:mm'" label="أختر تاريخ النهاية" v-model="EndDate"></VueCtkDateTimePicker>
                        </div>
                        <div class="col-md-12 py-5 text-center">
                            <button form="SearchByTimeForm" class="btn bg-white btn-lg">بحث</button>
                        </div>
                    </form>
                </div>

            </div>


        </div>
        <!--end::Search Start Date End Date-->

        <!--begin::Stats-->
        <div v-if="SearchedInvoices.length == 0" class=" card-header border-0 pt-5 row justify-content-center">
            <div class="col-md-4 text-center  ">
                <h4 class="card-title align-items-start flex-column">
                <span class="card-label font-weight-bolder text-dark">

                    اجمالى الوزن المباع ١٨ :
                    <b v-if="EmployeeStats.TotalSoldWeight_18 != null">{{EmployeeStats.TotalSoldWeight_18}}</b>
                    <b v-else>0</b>
                    جرام

                </span>
                </h4>
            </div>
            <div class="col-md-4 text-center border-right border-black  ">
                <h4 class="card-title align-items-start flex-column">
                <span class="card-label font-weight-bolder text-dark">

                    اجمالى الوزن المباع ٢١ :
                    <b v-if="EmployeeStats.TotalSoldWeight_21 != null">{{EmployeeStats.TotalSoldWeight_21}}</b>
                    <b v-else>0</b>
                    جرام

                </span>
                </h4>
            </div>
            <div class="col-md-4 text-center  border-right border-black" style="border-left : white !important">
                <h4 class="card-title align-items-start flex-column">
                <span class="card-label font-weight-bolder text-dark">
                    اجمالى المبيعات :
                    {{formatPrice(EmployeeStats.TotalSoldPrice    )}}

                    ج.م
                </span>
                </h4>
            </div>
        </div>

        <div v-else class="card-header border-0 pt-5 row justify-content-center">
            <div class="col-md-4 text-center  ">
                <h4 class="card-title align-items-start flex-column">
                <span class="card-label font-weight-bolder text-dark">

                    اجمالى الوزن المباع :
                    {{SearchedEmployeeStats.TotalSoldWeight}}

                    جرام

                </span>
                </h4>
            </div>
            <div class="col-md-4 text-center  border-right border-black" style="border-left : white !important">
                <h4 class="card-title align-items-start flex-column">
                <span class="card-label font-weight-bolder text-dark">
                    اجمالى المبيعات :
                    {{formatPrice(SearchedEmployeeStats.TotalSoldPrice)}}

                    ج.م
                </span>
                </h4>
            </div>
        </div>
        <!--end::Stats-->
        <div class="col-md-12 text-center my-5">
            <button class="btn btn-info" @click="GoToPrintPage()">طباعة تفصيلة الفواتير
            <i class="flaticon2-print icon-md"></i>
            </button>
        </div>
        <!--begin::Delete Search Result Card-->
        <div v-show="SearchedInvoices.length !=0" @click="SearchedInvoices = []" class="card card-custom bg-danger cursor-pointer">
            <div class="card-header border-0 justify-content-center">
                <div class="card-title ">
                    <h3 class="card-label text-white ">حذف نتائج البحث</h3>
                    <span class="card-icon">
                                            <i class="flaticon2-delete text-white"></i>
                                        </span>
                </div>

            </div>
        </div>
        <!--end::Delete Search Result Card-->
        <!--begin::Table-->
        <div class="table-responsive">
           <div v-if="SearchedInvoices.length == 0">
               <invoices-table  :Invoices="Invoices" @PrintInvoice="printInvoice"></invoices-table>
           </div>
            <div v-else-if="SearchedInvoices.length > 0">
                <invoices-table :Invoices="SearchedInvoices" @PrintInvoice="printInvoice"></invoices-table>
            </div>
            <!--begin::Pagination-->
            <div class="d-flex justify-content-center align-items-center text-center  flex-wrap">
                <div v-if="SearchedInvoices.length == 0" class="d-flex flex-wrap mr-3">
                    <a @click="FetchEmployeeInvoices(FetchPaginationData.current_page + 1,false)" v-if="FetchPaginationData.next_page_url" class="btn btn-icon btn-sm btn-light-primary mr-2 my-1">
                        <i class="ki ki-bold-arrow-next icon-xs"></i>
                    </a>


                    <a href="#" class="btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1">
                        صفحة

                        {{FetchPaginationData.current_page}}
                        من
                        {{FetchPaginationData.last_page}}
                    </a>

                    <a @click="FetchEmployeeInvoices(FetchPaginationData.current_page-1,false)" v-if="FetchPaginationData.prev_page_url" class="btn btn-icon btn-sm btn-light-primary mr-2 my-1">
                        <i class="ki ki-bold-arrow-back icon-xs"></i>
                    </a>
                </div>
                <div v-else class="d-flex flex-wrap mr-3">
                    <a @click="SearchEmployeeInvoices(SearchedPaginationData.current_page + 1,false)" v-if="SearchedPaginationData.next_page_url" class="btn btn-icon btn-sm btn-light-primary mr-2 my-1">
                        <i class="ki ki-bold-arrow-next icon-xs"></i>
                    </a>


                    <a href="#" class="btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1">
                        صفحة

                        {{SearchedPaginationData.current_page}}
                        من
                        {{SearchedPaginationData.last_page}}
                    </a>

                    <a @click="SearchEmployeeInvoices(SearchedPaginationData.current_page-1,false)" v-if="SearchedPaginationData.prev_page_url" class="btn btn-icon btn-sm btn-light-primary mr-2 my-1">
                        <i class="ki ki-bold-arrow-back icon-xs"></i>
                    </a>
                </div>

            </div>
            <!--end:: Pagination-->
        </div>
        <!--end::Table-->
        <!--begin::printInvoice-->
        <div>
            <print-invoice :Invoice="InvoiceToBePrinted" ref="printComponent"></print-invoice>
        </div>
        <!--end::printInvoice-->


        <loading-spinner v-if="LoadingSpinner"></loading-spinner>

    </div>
</template>

<script>

    export default {
        name: "EmployeeSales",
        props : {
            Employee:{},
        },
        data(){
            return {
                LoadingSpinner : false,
                Invoices : [],
                SearchedInvoices : [],
                FetchPaginationData: {
                    current_page :  '',
                   'last_page': '',
                    'next_page_url': '',
                    'prev_page_url': '',
                },
                SearchedPaginationData: {
                    current_page :  '',
                    last_page: '',
                    next_page_url: '',
                    prev_page_url: '',
                },
                EmployeeStats :{},
                SearchedEmployeeStats :{},
                maxDate : moment().toString(),
                StartDate : moment().format('YYYY-MM-DD H:mm'),
                EndDate: moment().format('YYYY-MM-DD H:mm'),
                InvoiceToBePrinted: null,
            }
        },
        created () {
            this.FetchEmployeeInvoices(1,true);
        },
        methods :{
            FetchEmployeeInvoices(page,WithStats = true){
                this.LoadingSpinner = true;
                axios.get(route('api.AdminEmployees.invoices',{'page':page,'employeeID':this.Employee.id,'WithStats':WithStats}))
                    .then(res => {
                        console.log(res);
                        if(WithStats){
                            this.EmployeeStats.TotalSoldPrice = res.data.EmployeeSalesStats.TotalSoldPrice;
                            this.EmployeeStats.TotalSoldWeight_18 = res.data.EmployeeSalesStats.TotalSoldWeight_18;
                            this.EmployeeStats.TotalSoldWeight_21 = res.data.EmployeeSalesStats.TotalSoldWeight_21;
                        }

                        this.Invoices = [];
                        this.Invoices.push(...res.data.Invoices.data);
                        this.FetchPaginationData.current_page = res.data.Invoices.current_page;
                        this.FetchPaginationData.last_page = res.data.Invoices.last_page;
                        this.FetchPaginationData.next_page_url = res.data.Invoices.next_page_url;
                        this.FetchPaginationData.prev_page_url = res.data.Invoices.prev_page_url;
                        this.LoadingSpinner = false;
                    }).catch(error=>{
                        this.LoadingSpinner = false;
                        console.log(error);
                    })
            },
             formatPrice(value) {
                    let val = (value/1).toFixed(2).replace('.', ',')
                    return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "")
             },
             formatCreatedAt(date) {
                    return moment(date).format(" H:mm , DD - MM - YYYY");
            },
            SearchEmployeeInvoices(page,WithStats = true){
                if(this.StartDate == null && this.EndDate == null){
                    this.$swal({
                        title:'لا توجد نتائج للبحث',
                        icon:'warning',
                    })
                }else{
                    this.LoadingSpinner = true;
                    axios.get(route('api.AdminEmployees.invoices',{'page':page,'employeeID':this.Employee.id,'WithStats':WithStats,'StartDate':this.StartDate,'EndDate':this.EndDate}))
                        .then(res => {
                            this.LoadingSpinner = false;
                            console.log(res);
                            this.SearchedInvoices = [];
                            this.SearchedInvoices.push(...res.data.Invoices.data);
                            if(this.SearchedInvoices.length == 0){
                                this.$swal({
                                    title:'لا توجد نتائج للبحث',
                                    icon:'warning',
                                })
                            }else{
                                if(WithStats){
                                    this.SearchedEmployeeStats.TotalSoldPrice = res.data.EmployeeSalesStats.TotalSoldPrice;
                                    this.SearchedEmployeeStats.TotalSoldWeight = res.data.EmployeeSalesStats.TotalSoldWeight;
                                }
                                this.SearchedPaginationData.current_page = res.data.Invoices.current_page;
                                this.SearchedPaginationData.last_page = res.data.Invoices.last_page;
                                this.SearchedPaginationData.next_page_url = res.data.Invoices.next_page_url;
                                this.SearchedPaginationData.prev_page_url = res.data.Invoices.prev_page_url;
                            }

                        }).catch(error=> {
                        this.LoadingSpinner = false;

                        console.log(error);
                    })
                }

            },
            printInvoice(invoice){
                this.InvoiceToBePrinted = invoice;
                this.InvoiceToBePrinted.seller_name = this.Employee.name;
                this.$refs.printComponent.generatePdf()
            },
            GoToPrintPage(){
                window.open(window.route('AdminEmployee.salesReport',{'employeeID':this.Employee.id,'employeeName':this.Employee.name,'StartDate':this.StartDate,'EndDate':this.EndDate}), '_blank');
            }
        }
    }
</script>

<style scoped>

</style>
