<template>
    <div class="container py-25">
        <div class="card card-custom">
            <div class="card-body ">
                    <div class="col-lg-12 col-xl-12 offset-xl-12">
                        <h3 class="font-size-h2 my-5">
                            انشاء فاتورة جديدة
                            <i class="flaticon-file-1 icon-xl text-dark-75"></i>

                        </h3>
                        <form id="CreateInvoiceForm" class="form py-25" @submit.prevent="StoreNewInvoice()">
                            <!--begin::Invoice Date-->
                            <div class="form-group row">
                                <label class="col-xl-2 col-lg-2 col-form-label font-size-h4 text-left">تاريخ الفاتورة :</label>
                                <div class="col-lg-4 col-xl-4 text-left ">
                                    <VueCtkDateTimePicker :maxDate="maxDate"  :format="'YYYY-MM-DD H:mm'" :formatted="'YYYY-MM-DD H:mm'" label="أختر التاريخ" v-model="Invoice.created_at"  :required="true" required></VueCtkDateTimePicker>
                                </div>
                            </div>
                            <!--end::Invoice Date-->
                            <!--begin::Invoice seller-->
                            <div class="form-group row">
                                <label class="col-xl-2 col-lg-2 col-form-label font-size-h4 text-left">اسم البائع :</label>
                                <div class="col-lg-4 col-xl-4 text-left pt-2">
                                    <v-select required :required="true" v-model="Invoice.employee_id" :label="Employee" :options="AvailableEmployees" :reduce="Employee => Employee.id" ></v-select>
                                </div>
                            </div>
                            <!--end::Invoice seller-->
                            <!--begin::buyer name-->
                           <!-- <div class="form-group row">
                                <label class="col-xl-2 col-lg-2 col-form-label font-size-h4 text-left">فاتورة إلى :</label>
                                <div class="col-lg-4 col-xl-4 text-left pt-2">
                                    <input class="form-control" v-model="Invoice.buyer_name">
                                </div>
                            </div>-->
                            <!--end::buyer name-->
                            <!--begin::Heading products info-->
                            <div class="col-lg-12 col-xl-12">
                                <div class="separator separator-dashed pt-5"></div>

                                <h3 class="font-size-h3 my-7">بيانات المنتجات :</h3>
                            </div>
                            <!--end::Heading products info-->


                            <!--begin::Add and choose Product-->
                            <div class="form-group row">
                                <!--begin::choose Product-->
                                <label class="col-xl-2 col-lg-2 col-form-label font-size-h4 text-left">المنتج :</label>
                                <div class="col-lg-3 col-xl-3 text-left pt-2">
                                    <v-select @deselected="deleteExistingProduct" v-model="currentSelectedProduct" @option:selected="addProductToSelectedInvoiceProductsList" required :required="true" :label="Product" :options="AvailableProducts" :reduce="Product => Product.id" ></v-select>
                                </div>
                                <!--end::choose Product-->
                                <!--begin::add Product-->
                                <!--end::add Product-->
                                <form class="col-xl-7 row" id="AddProductForm" @submit.prevent="AddedProduct.name != '' ? storeNewProduct() : ''">
                                    <label class="col-xl-3 col-lg-3 col-form-label font-size-h4 text-left">اضافة منتج جديد :</label>
                                    <div class="col-lg-7 col-xl-7 text-left     ">
                                        <input v-model="AddedProduct.name" type="text" class="form-control">
                                    </div>
                                    <div class="col-lg-2 col-xl-2 pt-1 ">
                                        <button form="AddProductForm" class="btn btn-warning btn-sm">اضافة</button>
                                    </div>
                                </form>
                                <!--end::add Product-->
                            </div>
                            <!--end::Add and choose Product-->

                            <!--begin::products Table-->
                            <div v-if="Invoice.SelectedProducts.length !== 0" class="my-6">
                                <create-invoice-products-table @productRemoved="RemoveProductFromSelectedInvoiceProductsList"
                                                    @ProductChanged="ReCalculateInvoicePrice"
                                                    :products="Invoice.SelectedProducts"
                                                    :AvailableEmployeesWithPatreena="AvailableEmployeesWithPatreena">
                                </create-invoice-products-table>
                            </div>
                            <!--end::products Table-->

                            <!--begin::From Buyer Heading-->
                            <div class="col-lg-12 col-xl-12">
                                <div class="separator separator-dashed pt-5"></div>

                                <h3 class="font-size-h3 my-7">مبادلة كسر :</h3>
                            </div>
                            <!--end::From Buyer Heading-->
                            <!--begin::products Table-->
                            <div v-if="Invoice.SelectedProducts.length !== 0" class="my-6">
                                <create-invoice-products-table @productRemoved="RemoveProductFromSelectedInvoiceProductsList"
                                                               @ProductChanged="ReCalculateInvoicePrice"
                                                               :products="Invoice.SelectedProducts"
                                                               :AvailableEmployeesWithPatreena="AvailableEmployeesWithPatreena"
                                                                :IsFromBuyerProducts="true">
                                </create-invoice-products-table>
                            </div>
                            <!--end::products Table-->
                            <!--begin::Add and choose Product-->
                            <div class="form-group row">
                                <!--begin::choose Product-->
                                <label class="col-xl-2 col-lg-2 col-form-label font-size-h4 text-left">المنتج :</label>
                                <div class="col-lg-3 col-xl-3 text-left pt-2">
                                    <v-select @deselected="deleteExistingProduct" v-model="currentSelectedProduct" @option:selected="addFromBuyerProductToSelectedInvoiceProductsList" required :required="true" :label="Product" :options="AvailableProducts" :reduce="Product => Product.id" ></v-select>
                                </div>
                                <!--end::choose Product-->
                                <!--begin::add Product-->
                                <!--end::add Product-->
                                <form class="col-xl-7 row" id="AddFromBuyerProductForm" @submit.prevent="AddedProduct.name != '' ? storeNewProduct() : ''">
                                    <label class="col-xl-3 col-lg-3 col-form-label font-size-h4 text-left">اضافة منتج جديد :</label>
                                    <div class="col-lg-7 col-xl-7 text-left     ">
                                        <input v-model="AddedProduct.name" type="text" class="form-control">
                                    </div>
                                    <div class="col-lg-2 col-xl-2 pt-1 ">
                                        <button form="AddFromBuyerProductForm" class="btn btn-warning btn-sm">اضافة</button>
                                    </div>
                                </form>
                                <!--end::add Product-->
                            </div>
                            <!--end::Add and choose Product-->

                            <!--begin::Invoice Total Price-->
                            <div class="row pt-10 pb-3 border-top border-top-gray justify-content-center ">
                                <label>مجموع الفاتورة </label>
                                <br>
                                <h3 class="mr-3">
                                    {{ formatPrice(Invoice.total_price)}}
                                    ج.م
                                </h3>
                            </div>
                            <!--end::Invoice Total Price-->
                            <!--begin::Paid In Cache And Visa-->
                            <div class="row pt-3 pb-3 ">
                                <div class="col-lg-6">
                                    <label>المدفوع كاش</label>
                                    <input v-model="Invoice.paid_in_cache" class="form-control" type="number" min="0">
                                </div>
                                <div class="col-lg-6">
                                    <label>المدفوع فيزا</label>
                                    <input v-model="Invoice.paid_in_visa" class="form-control" type="number" min="0">
                                </div>
                            </div>
                            <!--end::Paid In Cache And Visa-->
                            <div class="col-md-12 text-center">
                                <button class="btn btn-success" form="CreateInvoiceForm">انشاء</button>
                            </div>
                        </form>
                    </div>

            </div>
        </div>
        <loading-spinner v-if="LoadingSpinner"></loading-spinner>
    </div>
</template>

<script>
    export default {
        name: "InvoicesCreate",
        created() {
            this.FetchEmployees(route('api.AdminEmployees.index'));
            this.FetchProducts(route('api.AdminProducts.index'));
        },
        data(){
            return{
                LoadingSpinner : false,
                currentSelectedProduct:{},
                AvailableProducts : [],
                AvailableEmployees : [],
                AvailableEmployeesWithPatreena:[],
                maxDate: moment().toString(),
                Invoice : {
                    // 'buyer_name':'',
                    'total_price':0,
                    'actual_price':0,
                    'total_weight_18':0,
                    'total_weight_21':0,
                    'from_buyer_total_weight_18':0,
                    'from_buyer_total_weight_21':0,
                    'paid_in_cache':0,
                    'paid_in_visa':0,
                    'SelectedProducts':[],
                    'created_at': moment().format('YYYY-MM-DD H:mm'),
                },
                AddedProduct : {},
                TempAddedProduct : {},
                AddedProductFromBuyer : {},
            }
        },
        methods: {
            FetchEmployees(){
                this.LoadingSpinner = true;
                axios.get(route('api.AdminEmployees.index'))
                    .then((res) => {
                        res.data.employees.forEach(employee => {
                            if(employee.id != 1 ){
                                this.AvailableEmployees.push({'id':employee.id,'label':employee.name});
                            }
                            this.AvailableEmployeesWithPatreena.push({'id':employee.id,'label':employee.name});
                        })
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
            FetchProducts(){
                this.LoadingSpinner = true;
                axios.get(route('api.AdminProducts.index'))
                    .then((res) => {
                        res.data.products.forEach(product => {
                                this.AvailableProducts.push({'id':product.id,'label':product.name});
                        })
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
            storeNewProduct(){
                let formData = new FormData();
                formData.append('name',this.AddedProduct.name);
                this.LoadingSpinner = true;
                axios.post(route('AdminProducts.store'),formData)
                    .then(({data}) => {
                        this.LoadingSpinner = false;
                        this.AddedProduct.id = data.NewProduct.id;
                        this.$swal({
                            icon:'success',
                            title:'تم اضافة منتج جديد بنجاح',
                            showConfirmButton: false,
                            timer: 1200
                        })
                        this.AvailableProducts.push({id : this.AddedProduct.id , label:this.AddedProduct.name,})

                        this.TempAddedProduct.id = this.AddedProduct.id;
                        this.TempAddedProduct.label = this.AddedProduct.name;

                        this.addProductToSelectedInvoiceProductsList(this.TempAddedProduct);
                    }).catch(error => {
                        this.LoadingSpinner = false;
                        console.log(error);
                            this.$swal({
                                title:'حدث خطأ تأكد من البيانات',
                                icon:'error',
                            })
                    })

            },
            deleteExistingProduct(ExistingProduct){
                axios.delete(route('AdminProducts.destroy',ExistingProduct.id))
                    .then(res => {
                        this.$swal({
                            icon:'success',
                            title:'تم حذف منتج بنجاح',
                            showConfirmButton: false,
                            timer: 1000
                        })
                    }).catch(error => {
                        this.$swal({
                            title:'حدث خطأ تأكد من البيانات',
                            icon:'error',
                        })
                    })
                let index = this.AvailableProducts.findIndex(product => product.id ===ExistingProduct.id);
                this.AvailableProducts.splice(index,1);
            },
            addProductToSelectedInvoiceProductsList(NewProduct){

                this.Invoice.SelectedProducts.push({
                    name:NewProduct.label,
                    id:NewProduct.id,
                    description:'',
                    number_of_items:1,
                    total_price:0,
                    weight:1,
                    weight_type:18,
                    is_from_buyer:false,
                    is_bracelet:false,
                    owner_employee:'',
                })
                this.currentSelectedProduct = {};
            },
            addFromBuyerProductToSelectedInvoiceProductsList(NewProduct){

                this.Invoice.SelectedProducts.push({
                    name:NewProduct.label,
                    id:NewProduct.id,
                    description:'',
                    number_of_items:1,
                    total_price:0,
                    weight:1,
                    weight_type:18,
                    is_from_buyer:true,
                    is_bracelet:false,
                    owner_employee:'',
                })
                this.currentSelectedProduct = {};
            },
            RemoveProductFromSelectedInvoiceProductsList(product,index){
                this.Invoice.SelectedProducts.splice(index,1);
                this.$swal({
                    title:'تم حذف المنتج',
                    icon:'success',
                })
                this.ReCalculateInvoicePrice();
            },
            ReCalculateInvoicePrice(){
                this.Invoice.total_price = 0;
                this.Invoice.actual_price = 0;
                this.Invoice.total_weight_18 = 0;
                this.Invoice.total_weight_21 = 0;
                this.Invoice.from_buyer_total_weight_18 = 0;
                this.Invoice.from_buyer_total_weight_21 = 0;

                this.Invoice.SelectedProducts.forEach(product => {
                        if(product.owner_employee == this.Invoice.employee_id){
                            product.owner_employee = '';
                        }
                        if(product.hasOwnProperty('is_from_buyer') && product.is_from_buyer == true){
                            if(product.weight_type == '18'){
                                this.Invoice.from_buyer_total_weight_18 += parseFloat(product.weight);
                            }else{
                                this.Invoice.from_buyer_total_weight_21 += parseFloat(product.weight);
                            }
                            this.Invoice.total_price -= parseFloat(product.total_price);
                            product.owner_employee = '';
                        }else{
                            this.Invoice.total_price += parseFloat(product.total_price);
                            this.Invoice.actual_price += parseFloat(product.total_price);
                            if(product.weight_type == '18'){
                                this.Invoice.total_weight_18 += parseFloat(product.weight);
                            }else{
                                this.Invoice.total_weight_21 += parseFloat(product.weight);
                            }
                        }

                })
            },
            formatPrice(value) {
                let val = (value/1).toFixed(2).replace('.', ',')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "")
            },
            StoreNewInvoice(){
                if(!this.Invoice.hasOwnProperty('employee_id') || this.Invoice.employee_id == '' || this.Invoice.employee_id == undefined){
                    this.$swal({
                        title:'برجاء تحديد البائع',
                        icon:'warning',
                    })
                }
                else if(this.Invoice.SelectedProducts.length == 0){
                    this.$swal({
                        title:'الفاتورة يجب ان تحتوى على منتج واحد على الاقل',
                        icon:'warning',
                    })
                }
                else{
                    this.LoadingSpinner = true;
                    let formData = new FormData();
                    formData.append('created_at',this.Invoice.created_at);
                    // formData.append('buyer_name',this.Invoice.buyer_name);
                    formData.append('employee_id',this.Invoice.employee_id);
                    formData.append('products',JSON.stringify(this.Invoice.SelectedProducts));
                    formData.append('products_length',this.Invoice.SelectedProducts.length);
                    formData.append('total_price',this.Invoice.total_price);
                    formData.append('actual_price',this.Invoice.actual_price);
                    formData.append('total_weight_18',this.Invoice.total_weight_18);
                    formData.append('total_weight_21',this.Invoice.total_weight_21);
                    formData.append('from_buyer_total_weight_18',this.Invoice.from_buyer_total_weight_18);
                    formData.append('from_buyer_total_weight_21',this.Invoice.from_buyer_total_weight_21);
                    formData.append('paid_in_cache',this.Invoice.paid_in_cache != '' ? this.Invoice.paid_in_cache : 0);
                    formData.append('paid_in_visa',this.Invoice.paid_in_visa != '' ? this.Invoice.paid_in_visa: 0);
                    axios.post(route('AdminInvoices.store'),formData)
                        .then(res => {
                            console.log(res);
                            this.LoadingSpinner = false;
                            this.$swal.fire({
                                icon:'success',
                                title: 'تم انشاء فاتورة جديدة بنجاح',
                                text:'هل تريد اضافة فاتورة جديدة اخرة؟',
                                showCancelButton:true,
                                confirmButtonText: `اضافة فاتورة اخرى`,
                                cancelButtonText: `غلق`,
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    this.Invoice = {
                                        'total_price':0,
                                        'actual_price':0,
                                        'total_weight_18':0,
                                        'total_weight_21':0,
                                        'from_buyer_total_weight_18':0,
                                        'from_buyer_total_weight_21':0,
                                        'paid_in_cache':0,
                                        'paid_in_visa':0,
                                        'SelectedProducts':[],
                                        'created_at': moment().format('YYYY-MM-DD hh:mm'),
                                    };
                                    this.AddedProduct.name = '';
                                    this.TempAddedProduct = {};
                                } else if (result.isDismissed) {
                                    location.href = window.location.origin+"/AdminInvoices/main";
                                }
                            })
                        }).catch(error => {
                            this.LoadingSpinner =false;
                            console.log(error);
                        this.$swal({
                            title:'حدث خطأ راجع بيانات المنتجات',
                            icon:'error',
                        })
                    })
                }


            },
        }
    }
</script>

<style scoped>

</style>
