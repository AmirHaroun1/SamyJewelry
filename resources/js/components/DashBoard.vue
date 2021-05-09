<template>
    <div class="container mt-30">
        <div class="row">

            <!--begin::Stats card -->
            <div class="col-md-9">
                <div class="card card-custom  gutter-b">
                    <!--begin::Header-->
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title align-items-start justify-content-between flex-column">
                            <span class="card-label font-weight-bolder text-dark">بيانات الفواتير</span>

                            <button class="btn btn-info btn-sm my-4"@click="EnablePrintingMood()">طباعة</button>
                        </h3>
                        <div class="card-toolbar">
                            <div class="dropdown dropdown-inline" data-toggle="tooltip" title="" data-placement="left" data-original-title="بحث بالتاريخ">
                                <a href="#" class="btn btn-clean btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="ki ki-bold-more-hor"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-md dropdown-menu-left">
                                    <!--begin::Navigation-->
                                    <form class="row text-white p-5" id="SearchByTimeForm" @submit.prevent="FetchDashBoardData(1,false,true,true)">
                                        <div class="col-md-12">
                                            <label class="text-dark-75">تاريخ بداية المدة</label>
                                            <VueCtkDateTimePicker :maxDate="maxDate"  :format="'YYYY-MM-DD H:mm '" :formatted="'YYYY-MM-DD H:mm'" label="أختر تاريخ البداية" v-model="StartDate"></VueCtkDateTimePicker>
                                        </div>
                                        <div class="col-md-12 mt-4">
                                            <label class="text-dark-75">تاريخ نهاية المدة</label>
                                            <VueCtkDateTimePicker :maxDate="maxDate"  :format="'YYYY-MM-DD H:mm '" :formatted="'YYYY-MM-DD H:mm'" label="أختر تاريخ النهاية" v-model="EndDate"></VueCtkDateTimePicker>
                                        </div>
                                        <div class="col-md-12 py-5 text-center">
                                            <button form="SearchByTimeForm" class="btn bg-primary btn-lg text-white">بحث</button>
                                        </div>
                                    </form>
                                    <!--end::Navigation-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body pt-8">
                        <!--begin::Item-->
                        <div class="d-flex align-items-center pb-5 border-bottom border-bottom-gray">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-40 symbol-light-primary mr-5">
														<span class="symbol-label">
															<span class="svg-icon svg-icon-xl svg-icon-primary">
																<!--begin::Svg Icon | path:assets/media/svg/icons/Home/Library.svg-->
																<i class="flaticon-statistics icon-xl"></i>
                                                                <!--end::Svg Icon-->
															</span>
														</span>
                            </div>
                            <!--end::Symbol-->
                            <!--begin::Text-->
                            <div class="d-flex flex-column font-weight-bold">
                                <a href="#" class="text-dark text-hover-primary mb-1 font-size-lg">

                                     عدد الفواتير :
                                    <b v-if="InvoicesStats.TotalInvoices != null">{{InvoicesStats.TotalInvoices}}</b>
                                    <b v-else>0</b>
                                </a>
                            </div>
                            <!--end::Text-->
                        </div>
                        <!--end::Item-->

                        <!--begin::Money Stats-->
                        <div class="row border-bottom border-bottom-gray">
                            <div class="col-md-6 ">
                                <!--begin::Item-->
                                <div class="d-flex align-items-center mb-10 mt-5">
                                    <!--begin::Symbol-->
                                    <div class="symbol symbol-40 symbol-light-warning mr-5">
                                    <span class="symbol-label">
                                        <span class="svg-icon svg-icon-xl svg-icon-primary">
                                            <!--begin::Svg Icon | path:assets/media/svg/icons/Home/Library.svg-->
                                            <i class="flaticon-coins icon-xl"></i>
                                            <!--end::Svg Icon-->
                                        </span>
                                    </span>
                                    </div>
                                    <!--end::Symbol-->
                                    <!--begin::Text-->
                                    <div class="d-flex flex-column font-weight-bold">
                                        <a href="#" class="text-dark text-hover-primary mb-1 font-size-lg">
                                            اجمالي قيمة الفواتير :
                                            <b>{{InvoicesStats.TotalSoldPrice}}</b>
                                            ج.م
                                        </a>
                                    </div>
                                    <!--end::Text-->
                                </div>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <div class="d-flex align-items-center mb-10">
                                    <!--begin::Symbol-->
                                    <div class="symbol symbol-40 symbol-light-warning mr-5">
                                    <span class="symbol-label">
                                        <span class="svg-icon svg-icon-xl svg-icon-primary">
                                            <!--begin::Svg Icon | path:assets/media/svg/icons/Home/Library.svg-->
                                            <i class="flaticon-coins icon-xl"></i>
                                            <!--end::Svg Icon-->
                                        </span>
                                    </span>
                                    </div>
                                    <!--end::Symbol-->
                                    <!--begin::Text-->
                                    <div class="d-flex flex-column font-weight-bold">
                                        <a href="#" class="text-dark text-hover-primary mb-1 font-size-lg">
                                            اجمالي قيمة المباع :
                                            <b >{{InvoicesStats.TotalActualPrice}}</b>
                                            ج.م
                                        </a>
                                    </div>
                                    <!--end::Text-->
                                </div>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <div class="d-flex align-items-center pb-5">
                                    <!--begin::Symbol-->
                                    <div class="symbol symbol-40 symbol-light-warning mr-5">
                                    <span class="symbol-label">
                                        <span class="svg-icon svg-icon-xl svg-icon-primary">
                                            <!--begin::Svg Icon | path:assets/media/svg/icons/Home/Library.svg-->
                                            <i class="flaticon-coins icon-xl"></i>
                                            <!--end::Svg Icon-->
                                        </span>
                                    </span>
                                    </div>
                                    <!--end::Symbol-->
                                    <!--begin::Text-->
                                    <div class="d-flex flex-column font-weight-bold">
                                        <a href="#" class="text-dark text-hover-primary mb-1 font-size-lg">
                                            اجمالي قيمة الكسر :
                                            <b>{{ConvertToPositive(InvoicesStats.TotalSoldPrice - InvoicesStats.TotalActualPrice)}}</b>
                                            ج.م
                                        </a>
                                    </div>
                                    <!--end::Text-->
                                </div>
                                <!--end::Item-->
                            </div>
                            <!--begin::visa and cache stats-->
                            <div class="col-md-6">
                                <!--begin::Item-->
                                <div class="d-flex align-items-center mt-15">
                                    <!--begin::Symbol-->
                                    <div class="symbol symbol-40 symbol-light-success mr-5">
                                    <span class="symbol-label">
                                        <span class="svg-icon svg-icon-xl svg-icon-primary">
                                            <!--begin::Svg Icon | path:assets/media/svg/icons/Home/Library.svg-->
                                            <i class="fab fa-cc-visa"></i>
                                            <!--end::Svg Icon-->
                                        </span>
                                    </span>
                                    </div>
                                    <!--end::Symbol-->
                                    <!--begin::Text-->
                                    <div class="d-flex flex-column font-weight-bold">
                                        <a href="#" class="text-dark text-hover-primary mb-1 font-size-lg">
                                            اجمالي المدفوع فيزا :
                                            <b >{{InvoicesStats.TotalPaidInVisa}}</b>
                                            ج.م
                                        </a>
                                    </div>
                                    <!--end::Text-->
                                </div>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <div class="d-flex align-items-center mt-15">
                                    <!--begin::Symbol-->
                                    <div class="symbol symbol-40 symbol-light-success mr-5">
                                    <span class="symbol-label">
                                        <span class="svg-icon svg-icon-xl svg-icon-primary">
                                            <!--begin::Svg Icon | path:assets/media/svg/icons/Home/Library.svg-->
                                            <i class="la la-dollar"></i>
                                            <!--end::Svg Icon-->
                                        </span>
                                    </span>
                                    </div>
                                    <!--end::Symbol-->
                                    <!--begin::Text-->
                                    <div class="d-flex flex-column font-weight-bold">
                                        <a href="#" class="text-dark text-hover-primary mb-1 font-size-lg">
                                            اجمالي المدفوع كاش :
                                            <b >{{InvoicesStats.TotalPaidInCache}}</b>
                                            ج.م
                                        </a>
                                    </div>
                                    <!--end::Text-->
                                </div>
                                <!--end::Item-->
                            </div>
                            <!--end::visa and cache stats-->

                        </div>
                        <!--end::Money Stats-->

                        <!--begin::weight Stats-->
                            <div class="row border-bottom border-bottom-gray">
                                <div class="col-md-6">
                                    <!--begin::Item-->
                                    <div class="d-flex align-items-center my-5">
                                        <!--begin::Symbol-->
                                        <div class="symbol symbol-40 symbol-light-info mr-5">
                                    <span class="symbol-label">
                                        <span class="svg-icon svg-icon-lg svg-icon-info">
                                            <i class="fas fa-balance-scale-left"></i>
                                        </span>
                                    </span>
                                        </div>
                                        <!--end::Symbol-->
                                        <!--begin::Text-->
                                        <div class="d-flex flex-column font-weight-bold">
                                            <a class="text-dark text-hover-primary mb-1 font-size-lg">
                                                مباع عيار ١٨ :
                                                {{InvoicesStats.TotalSoldWeight_18}}
                                                جرام
                                            </a>
                                        </div>
                                        <!--end::Text-->
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="d-flex align-items-center my-5">
                                        <!--begin::Symbol-->
                                        <div class="symbol symbol-40 symbol-light-info mr-5">
                                    <span class="symbol-label">
                                        <span class="svg-icon svg-icon-lg svg-icon-info">
                                            <i class="fas fa-balance-scale-left"></i>
                                        </span>
                                    </span>
                                        </div>
                                        <!--end::Symbol-->
                                        <!--begin::Text-->
                                        <div class="d-flex flex-column font-weight-bold">
                                            <a class="text-dark text-hover-primary mb-1 font-size-lg">
                                                مباع عيار ٢١ :
                                                {{InvoicesStats.TotalSoldWeight_21}}
                                                جرام
                                            </a>
                                        </div>
                                        <!--end::Text-->
                                    </div>
                                    <!--end::Item-->
                                </div>
                                <div class="col-md-6">
                                    <!--begin::Item-->
                                    <div class="d-flex align-items-center my-5">
                                        <!--begin::Symbol-->
                                        <div class="symbol symbol-40 symbol-light-info mr-5">
                                    <span class="symbol-label">
                                        <span class="svg-icon svg-icon-lg svg-icon-info">
                                            <i class="fas fa-balance-scale-right"></i>
                                        </span>
                                    </span>
                                        </div>
                                        <!--end::Symbol-->
                                        <!--begin::Text-->
                                        <div class="d-flex flex-column font-weight-bold">
                                            <a class="text-dark text-hover-primary mb-1 font-size-lg">
                                                كسر عيار ١٨ :
                                                {{InvoicesStats.FromBuyerTotalWeight_18}}
                                                جرام
                                            </a>
                                        </div>
                                        <!--end::Text-->
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="d-flex align-items-center my-5">
                                        <!--begin::Symbol-->
                                        <div class="symbol symbol-40 symbol-light-info mr-5">
                                    <span class="symbol-label">
                                        <span class="svg-icon svg-icon-lg svg-icon-info">
                                            <i class="fas fa-balance-scale-right"></i>
                                        </span>
                                    </span>
                                        </div>
                                        <!--end::Symbol-->
                                        <!--begin::Text-->
                                        <div class="d-flex flex-column font-weight-bold">
                                            <a class="text-dark text-hover-primary mb-1 font-size-lg">
                                                كسر عيار ٢١ :
                                                {{InvoicesStats.FromBuyerTotalWeight_21}}
                                                جرام
                                            </a>
                                        </div>
                                        <!--end::Text-->
                                    </div>
                                    <!--end::Item-->
                                </div>
                            </div>
                        <!--end::weight Stats-->
                        <!--begin::paid Stats-->
                        <div class="row">
                            <div class="col-md-6">
                                <!--begin::Item-->
                                <div class="d-flex align-items-center my-5">
                                    <!--begin::Symbol-->
                                    <div class="symbol symbol-40 symbol-light-success mr-5">
                                    <span class="symbol-label">
                                        <span class="svg-icon svg-icon-lg svg-icon-info">
                                            <i class="la la-dollar"></i>
                                        </span>
                                    </span>
                                    </div>
                                    <!--end::Symbol-->
                                    <!--begin::Text-->
                                    <div class="d-flex flex-column font-weight-bold">
                                        <a class="text-dark text-hover-primary mb-1 font-size-lg">
                                            المدفوع نقدى :
                                            {{PaymentsStats.paid_price}}
                                            ج.م
                                        </a>
                                    </div>
                                    <!--end::Text-->
                                </div>
                                <!--end::Item-->
                            </div>
                            <div class="col-md-6">
                                <!--begin::Item-->
                                <div class="d-flex align-items-center my-5">
                                    <!--begin::Symbol-->
                                    <div class="symbol symbol-40 symbol-light-success mr-5">
                                    <span class="symbol-label">
                                        <span class="svg-icon svg-icon-lg svg-icon-info">
                                            <i class="fas fa-weight"></i>
                                        </span>
                                    </span>
                                    </div>
                                    <!--end::Symbol-->
                                    <!--begin::Text-->
                                    <div class="d-flex flex-column font-weight-bold">
                                        <a class="text-dark text-hover-primary mb-1 font-size-lg">
                                            مدفوع عيار ١٨ :
                                            {{PaymentsStats.paid_weight_18}}
                                            جرام
                                        </a>
                                    </div>
                                    <!--end::Text-->
                                </div>
                                <!--end::Item-->
                            </div>
                            <div class="col-md-6">
                                <!--begin::Item-->
                                <div class="d-flex align-items-center my-5">
                                    <!--begin::Symbol-->
                                    <div class="symbol symbol-40 symbol-light-success mr-5">
                                    <span class="symbol-label">
                                        <span class="svg-icon svg-icon-lg svg-icon-info">
                                            <i class="fas fa-weight"></i>
                                        </span>
                                    </span>
                                    </div>
                                    <!--end::Symbol-->
                                    <!--begin::Text-->
                                    <div class="d-flex flex-column font-weight-bold">
                                        <a class="text-dark text-hover-primary mb-1 font-size-lg">
                                            مدفوع عيار ٢١ :
                                            {{PaymentsStats.paid_weight_21}}
                                            جرام
                                        </a>
                                    </div>
                                    <!--end::Text-->
                                </div>
                                <!--end::Item-->
                            </div>
                        </div>
                        <!--end::paid Stats-->

                    </div>
                    <!--end::Body-->
                    <div v-if="PrintingMood">
                        <print-dashboard :InvoicesStats="InvoicesStats" :PaymentsStats="PaymentsStats"></print-dashboard>

                    </div>
                </div>
            </div>
            <!--end::Stats card-->
            <!--begin::top employees card -->
            <div class="col-md-3">
                <div class="card card-custom card-stretch gutter-b">
                    <div class="card-header border-0">
                        <h3 class="card-title font-weight-bolder text-dark"> الأكثر نشاطا الشهر الحالي</h3>
                    </div>
                    <div class=" pt-2">
                        <!--begin::Item-->
                        <div v-for="employee in TopMonthEmployees" v-if="employee.id != 1" class="d-flex align-items-center mb-10">

                                <!--begin::Text-->
                                <div class="d-flex flex-column flex-grow-1 mr-5 font-weight-bold">
                                    <h4>
                                        <a :href="route('AdminEmployees.edit',employee.id)" class="text-primary text-hover-primary mb-1 font-size-xl">{{employee.name}}</a>
                                    </h4>
                                </div>
                                <!--end::Text-->
                                <!--begin::Dropdown-->
                                <div class="dropdown dropdown-inline ml-2" data-toggle="tooltip" title="" data-placement="right" data-original-title="Quick actions">
                                    <a href="#" class="btn btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="ki ki-bold-more-hor"></i>
                                    </a>
                                    <div class="dropdown-menu p-0 m-0 dropdown-menu-md dropdown-menu-right" style="">
                                        <!--begin::Navigation-->
                                        <ul class="navi navi-hover">
                                            <li class="navi-header font-weight-bold py-4">
                                                <span class="font-size-lg">ارقام الشهر</span>
                                                <i class="flaticon2-information icon-md text-muted" data-toggle="tooltip" data-placement="right" title="" data-original-title="Click to learn more..."></i>
                                            </li>
                                            <li class="navi-separator mb-3 opacity-70"></li>
                                            <li class="navi-item">
                                                <a href="#" class="navi-link">
                                                        <span class="navi-text">
                                                            <span class="label label-xl label-inline">
                                                                قيمة المباع :
                                                                {{employee.CurrentMonthSales}}
                                                                ج.م
                                                            </span>
                                                        </span>
                                                </a>
                                            </li>
                                            <li class="navi-item">
                                                <a href="#" class="navi-link">
                                                        <span class="navi-text">
                                                            <span class="label label-xl label-inline">
                                                                الوزن المباع :
                                                                {{employee.CurrentMonthTotalWeight}}
                                                                جرام
                                                            </span>
                                                        </span>
                                                </a>
                                            </li>
                                            <li class="navi-item">
                                                <a href="#" class="navi-link">
                                                        <span class="navi-text">
                                                            <span class="label label-xl label-inline">
                                                                الوزن المباع ١٨ :
                                                                {{employee.CurrentMonthTotalWeight_18}}
                                                                جرام
                                                            </span>
                                                        </span>
                                                </a>
                                            </li>
                                            <li class="navi-item">
                                                <a href="#" class="navi-link">
                                                        <span class="navi-text">
                                                            <span class="label label-xl label-inline">
                                                                الوزن المباع ٢١ :
                                                                {{employee.CurrentMonthTotalWeight_21}}
                                                                جرام
                                                            </span>
                                                        </span>
                                                </a>
                                            </li>


                                            <li class="navi-separator mt-3 opacity-70"></li>

                                        </ul>
                                        <!--end::Navigation-->
                                    </div>
                                </div>
                                <!--end::Dropdown-->


                        </div>
                        <!--end::Item-->
                    </div>
                    <div class="card-footer text-center justify-content-center">
                        <div class="d-flex flex-wrap mr-3">
                            <a @click="FetchDashBoardData(FetchPaginationData.current_page + 1,true,false,false)" v-if="FetchPaginationData.next_page_url" class="btn btn-icon btn-sm btn-light-primary mr-2 my-1">
                                <i class="ki ki-bold-arrow-next icon-xs"></i>
                            </a>
                            <a href="#" class="btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1">
                                صفحة

                                {{FetchPaginationData.current_page}}
                                من
                                {{FetchPaginationData.last_page}}
                            </a>

                            <a @click="FetchDashBoardData(FetchPaginationData.current_page-1,true,false,false)" v-if="FetchPaginationData.prev_page_url" class="btn btn-icon btn-sm btn-light-primary mr-2 my-1">
                                <i class="ki ki-bold-arrow-back icon-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::top employees card -->

        </div>

        <loading-spinner v-if="LoadingSpinner"></loading-spinner>
    </div>
</template>

<script>
    export default {
        name: "DashBoard",
        created(){
            this.FetchDashBoardData(1,true,true,true);
        },
        data(){
            return {
                LoadingSpinner : false,
                InvoicesStats : {},
                TopMonthEmployees : [],
                PaymentsStats : {},
                maxDate:moment().toString(),
                StartDate : moment().format('YYYY-MM-DD') + ' ' + '00:00',
                EndDate: moment().format('YYYY-MM-DD') + ' ' + '23:59',
                FetchPaginationData: {
                    'current_page': '',
                    'last_page': '',
                    'next_page_url': '',
                    'prev_page_url': '',
                },
                PrintingMood:false,
            }
        },
        methods: {
            FetchDashBoardData(page,WithEmployeesStats,WithInvoicesStats,WithPaymentsStats){
                this.LoadingSpinner = true;

                axios.get(route('api.DashBoard.index',{'page':page,'StartDate':this.StartDate,'EndDate':this.EndDate,'WithEmployeesStats':WithEmployeesStats,'WithInvoicesStats':WithInvoicesStats,'WithPaymentsStats':WithPaymentsStats}))
                    .then((res) => {
                        console.log(res);

                        if (WithInvoicesStats){
                            this.InvoicesStats = {};
                            this.InvoicesStats = res.data.InvoiceStats;
                            for(const key in this.InvoicesStats){
                                if(this.InvoicesStats[key] == null){
                                    this.InvoicesStats[key] = 0;
                                }
                            }
                        }if(WithPaymentsStats){
                            this.PaymentsStats = res.data.PaymentStats;
                            for(const key in this.PaymentsStats){
                                if(this.PaymentsStats[key] == null){
                                    this.PaymentsStats[key] = 0;
                                }
                            }
                        }
                        if(WithEmployeesStats){
                            this.TopMonthEmployees = [];
                            this.TopMonthEmployees.push(...res.data.employees.data);
                            this.FetchPaginationData.current_page = res.data.employees.current_page;
                            this.FetchPaginationData.last_page = res.data.employees.last_page;
                            this.FetchPaginationData.next_page_url = res.data.employees.next_page_url;
                            this.FetchPaginationData.prev_page_url = res.data.employees.prev_page_url;
                        }

                        this.LoadingSpinner = false;
                    }).catch(error => {
                        console.log(res);
                    this.LoadingSpinner = false;

                })
            },
            ConvertToPositive(value){
                if(value < 0){
                    return -1 * value;
                }else {
                    return value;
                }
            },
            EnablePrintingMood(){
                this.PrintingMood = true;
            }
        }
    }
</script>

<style scoped>

</style>
