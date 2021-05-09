<template>
    <div>
        <!--begin::Search-->
        <div class="row justify-content-center">
            <div class="mt-30 card card-custom bg-success">
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
                    <form class="card-body row text-white" id="SearchByTimeForm" @submit.prevent="SearchInvoices(1)">
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
        <!--end::Search-->
        <div class="  mt-10 pt-10 pb-10  card card-custom gutter-b">
                <!--begin::Header-->
                <div class="card-header border-0 py-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label font-weight-bolder text-dark">الفواتير</span>
                    </h3>
                    <div class="card-toolbar">
                        <a :href="route('AdminInvoices.create')" class="btn btn-success font-weight-bolder font-size-sm">فاتورة جديدة</a>
                    </div>

                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body pt-0 pb-3">
                    <div class="tab-content">
                        <!--begin::Delete Search Result Card-->
                        <div v-show="SearchedInvoices.length !=0" @click="SearchedInvoices = []" class="card card-custom bg-danger cursor-pointer my-10">
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
                            <table class="table table-head-custom table-vertical-center table-head-bg table-borderless">
                                <thead>
                                <tr class="text-left">
                                    <th style="min-width: 40px">
                                        <span class="text-dark-75">

                                        </span>
                                    </th>
                                    <th style="min-width: 100px">
                                        <span class="text-dark-75">
                                             البائع
                                        </span>
                                    </th>
                                    <th style="min-width: 100px"  >
                                        <span class="text-dark-75">
                                            قيمة الفاتورة
                                        </span>
                                    </th>
                                    <th style="min-width: 100px"  >
                                        <span class="text-dark-75">
                                            الوزن ١٨
                                        </span>
                                    </th>
                                    <th style="min-width: 100px"  >
                                        <span class="text-dark-75">
                                            الوزن ٢١
                                        </span>
                                    </th>
                                    <th style="min-width: 100px">
                                        <span class="text-dark-75">
                                            قيمة المباع
                                        </span>
                                    </th>
                                    <th style="min-width: 100px">
                                        <span class="text-dark-75">
                                            وزن الكسر ١٨
                                        </span>
                                    </th>
                                    <th style="min-width: 100px">
                                        <span class="text-dark-75">
                                            وزن الكسر ٢١
                                        </span>
                                    </th>
                                    <th style="min-width: 100px">
                                        <span class="text-dark-75">
                                            قيمة الكسر
                                        </span>
                                    </th>
                                    <th style="min-width: 100px">
                                        <span class="text-dark-75">
                                        تاريخ الفاتورة
                                        </span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody v-if="SearchedInvoices.length == 0">
                                <tr v-for="Invoice in Invoices" class="text-left">
                                    <td>
                                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">
                                            <a class="btn btn-success" :href="route('AdminInvoices.edit',Invoice.id)">
                                                                    الفاتورة
                                                <i class="flaticon2-file icon-md"></i>
                                            </a>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg"><a :href="route('AdminEmployees.edit',Invoice.seller_id)">{{Invoice.seller_name}}</a></span>
                                    </td>
                                    <td>
                                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{formatPrice(Invoice.total_price)}} ج.م</span>
                                    </td>
                                    <td>
                                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{Invoice.total_weight_18}} جرام</span>
                                    </td>
                                    <td>
                                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{Invoice.total_weight_21}} جرام</span>
                                    </td>
                                    <td>
                                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{formatPrice(Invoice.actual_price)}} ج.م</span>
                                    </td>
                                    <td>
                                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{Invoice.from_buyer_total_weight_18}} جرام</span>
                                    </td>
                                    <td>
                                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{Invoice.from_buyer_total_weight_21}} جرام</span>
                                    </td>
                                    <td>
                                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{formatPrice(Invoice.actual_price - Invoice.total_price)}} ج.م</span>
                                    </td>
                                    <td>
                                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{formatCreatedAt(Invoice.created_at)}}</span>
                                    </td>
                                    <td>
                                        <span class="text-dark-75 font-weight-bolder d-block font-size-sm">
                                                <a class="btn btn-success btn-sm" @click="print(Invoice)">
                                                    <i class="flaticon2-print icon-md"></i>
                                                </a>
                                        </span>
                                    </td>
                                </tr>
                                </tbody>
                                <tbody v-else>
                                <tr v-for="Invoice in SearchedInvoices" class="text-left">
                                    <td>
                                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">
                                            <a class="btn btn-success" :href="route('AdminInvoices.edit',Invoice.id)">
                                                                    الفاتورة
                                                <i class="flaticon2-file icon-md"></i>
                                            </a>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg"><a :href="route('AdminEmployees.edit',Invoice.seller_id)">{{Invoice.seller_name}}</a></span>
                                    </td>
                                    <td>
                                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{formatPrice(Invoice.total_price)}} ج.م</span>
                                    </td>
                                    <td>
                                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{Invoice.total_weight_18}} جرام</span>
                                    </td>
                                    <td>
                                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{Invoice.total_weight_21}} جرام</span>
                                    </td>
                                    <td>
                                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{formatPrice(Invoice.actual_price)}} ج.م</span>
                                    </td>
                                    <td>
                                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{Invoice.from_buyer_total_weight_18}} جرام</span>
                                    </td>
                                    <td>
                                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{Invoice.from_buyer_total_weight_21}} جرام</span>
                                    </td>
                                    <td>
                                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{formatPrice(Invoice.actual_price - Invoice.total_price)}} ج.م</span>
                                    </td>
                                    <td>
                                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{formatCreatedAt(Invoice.created_at)}}</span>
                                    </td>
                                    <td>
                                        <span class="text-dark-75 font-weight-bolder d-block font-size-sm">
                                                <a class="btn btn-success btn-sm" @click="print(Invoice)">
                                                    <i class="flaticon2-print icon-md"></i>
                                                </a>
                                        </span>
                                    </td>
                                </tr>
                                </tbody>

                            </table>

                            <!--begin::Pagination-->
                            <div class="d-flex justify-content-center align-items-center text-center  flex-wrap">
                                <div v-if="SearchedInvoices.length == 0" class="d-flex flex-wrap mr-3">
                                    <a @click="FetchInvoices(FetchPaginationData.current_page + 1)" v-if="FetchPaginationData.next_page_url" class="btn btn-icon btn-sm btn-light-primary mr-2 my-1">
                                        <i class="ki ki-bold-arrow-next icon-xs"></i>
                                    </a>


                                    <a href="#" class="btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1">
                                        صفحة

                                        {{FetchPaginationData.current_page}}
                                        من
                                        {{FetchPaginationData.last_page}}
                                    </a>

                                    <a @click="FetchInvoices(FetchPaginationData.current_page-1)" v-if="FetchPaginationData.prev_page_url" class="btn btn-icon btn-sm btn-light-primary mr-2 my-1">
                                        <i class="ki ki-bold-arrow-back icon-xs"></i>
                                    </a>
                                </div>
                                <div v-else class="d-flex flex-wrap mr-3">
                                    <a @click="SearchInvoices(SearchedPaginationData.current_page + 1)" v-if="SearchedPaginationData.next_page_url" class="btn btn-icon btn-sm btn-light-primary mr-2 my-1">
                                        <i class="ki ki-bold-arrow-next icon-xs"></i>
                                    </a>


                                    <a href="#" class="btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1">
                                        صفحة

                                        {{SearchedPaginationData.current_page}}
                                        من
                                        {{SearchedPaginationData.last_page}}
                                    </a>

                                    <a @click="SearchInvoices(SearchedPaginationData.current_page-1)" v-if="SearchedPaginationData.prev_page_url" class="btn btn-icon btn-sm btn-light-primary mr-2 my-1">
                                        <i class="ki ki-bold-arrow-back icon-xs"></i>
                                    </a>
                                </div>

                            </div>
                            <!--end:: Pagination-->
                        </div>
                        <!--end::Table-->
                    </div>
                    <!--begin::printInvoice-->
                    <div>
                        <print-invoice :Invoice="InvoiceToBePrinted" ref="printComponent"></print-invoice>
                    </div>
                    <!--end::printInvoice-->
                </div>
                <!--end::Body-->
            </div>

        <loading-spinner v-if="LoadingSpinner"></loading-spinner>
    </div>
</template>

<script>
    export default {
        name: "MainInvoices",
        created() {
            this.FetchInvoices();
        },
        data() {
            return {
                'LoadingSpinner':false,
                'Invoices':[],
                'SearchedInvoices':[],
                'SearchInvoiceDate':'',
                'SearchInvoiceSeller':'',
                'SellingEmployees' : [],
                'FilterOptions' : {
                  'seller_id':'',
                  'total_price':'',
                  'weight':'',

                },
                FetchPaginationData: {
                    'current_page': '',
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
                maxDate:moment().toString(),
                StartDate : moment().format('YYYY-MM-DD H:mm'),
                EndDate: moment().format('YYYY-MM-DD H:mm'),
                InvoiceToBePrinted:{},
            }
        },
        methods: {
            FetchInvoices(page = 1) {
                this.LoadingSpinner = true;
                axios.get(route('api.AdminInvoices.index',{'page':page}))
                    .then((res) => {

                        this.Invoices = [];
                        this.Invoices.push(...res.data.Invoices.data);
                        this.FetchPaginationData.current_page = res.data.Invoices.current_page;
                        this.FetchPaginationData.last_page = res.data.Invoices.last_page;
                        this.FetchPaginationData.next_page_url = res.data.Invoices.next_page_url;
                        this.FetchPaginationData.prev_page_url = res.data.Invoices.prev_page_url;
                        this.LoadingSpinner = false;
                    }).catch(error => {
                    this.LoadingSpinner = false;
                    console.log(error);
                    this.$swal({
                        title: 'حدث خطأ يرجي اعادة المحاولة',
                        icon: 'error',
                    })
                })
            },
            SearchInvoices(page=1) {
                if (this.StartDate == null && this.EndDate == null) {
                    this.$swal({
                        title: 'لا توجد نتائج للبحث',
                        icon: 'warning',
                    })
                } else {
                    this.LoadingSpinner = true;
                    axios.get(route('api.AdminInvoices.index', {
                        'page': page,
                        'StartDate': this.StartDate,
                        'EndDate': this.EndDate
                    })).then(res => {
                        this.LoadingSpinner = false;
                        console.log(res);
                            this.SearchedInvoices = [];
                            this.SearchedInvoices.push(...res.data.Invoices.data);
                            if (this.SearchedInvoices.length == 0) {
                                this.$swal({
                                    title: 'لا توجد نتائج للبحث',
                                    icon: 'warning',
                                })
                            } else {
                                this.SearchedPaginationData.current_page = res.data.Invoices.current_page;
                                this.SearchedPaginationData.last_page = res.data.Invoices.last_page;
                                this.SearchedPaginationData.next_page_url = res.data.Invoices.next_page_url;
                                this.SearchedPaginationData.prev_page_url = res.data.Invoices.prev_page_url;
                            }

                        }).catch(error => {
                        this.LoadingSpinner = false;
                        console.log(error);
                    })
                }
            },
            print(Invoice){
                if(!Invoice.hasOwnProperty('products'))
                {
                    this.LoadingSpinner = true;
                    axios.get(route('api.AdminInvoices.loadProducts',Invoice.id))
                        .then(({data}) => {
                            this.LoadingSpinner = false;
                            this.$set(Invoice,'products',[]);
                            Invoice.products.push(...data.invoice.products);
                            console.log(data.invoice);
                            this.printInvoice(Invoice);
                        }).catch(error => {
                         this.LoadingSpinner = false;
                    })
                }else{
                    this.printInvoice(Invoice);
                }

            },
            printInvoice(invoice){
                this.InvoiceToBePrinted = invoice;
                this.$refs.printComponent.generatePdf();
            },
            formatPrice(value) {
                let val = (value/1).toFixed(2).replace('.', ',')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "")
            },
            formatCreatedAt(date) {
                return moment(date).format(" HH:mm , DD - MM - YYYY");
            }
        }
    }

</script>

<style scoped>

</style>
