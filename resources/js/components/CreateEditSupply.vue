<template>

        <div class="container py-25">
            <div class="card card-custom">
                <div class="card-body ">
                    <div class="col-lg-12 col-xl-12 offset-xl-12">
                        <h3 class="font-size-h2 my-5">
                            <b v-if="Mood != 'edit'">انشاء امر توريد جديد</b>
                            <b v-else>تعديل امر توريد </b>
                            <i class="flaticon-file-1 icon-xl text-dark-75"></i>
                        </h3>

                        <form id="CreateSupplyForm" class="form py-25" @submit.prevent="Mood == 'edit'?UpdateSupplyData():StoreNewSupply()">
                            <!--begin::Supplier Name-->
                            <div class="form-group row">
                                <label class="col-xl-2 col-lg-2 col-form-label font-size-h4 text-left">اسم المورد</label>
                                <div class="col-lg-4 col-xl-4 text-left ">
                                    <input class="form-control" v-model="Supplier.name" disabled>
                                </div>
                            </div>
                            <!--end::Supplier Name-->
                            <!--begin::weight_18-->
                            <div class="form-group row">
                                <label class="col-xl-2 col-lg-2 col-form-label font-size-h4 text-left">اضافة ذهب عيار ١٨</label>
                                <div class="col-lg-4 col-xl-4 text-left ">
                                    <input class="form-control" v-model="Supply.weight_amount_18">
                                </div>
                                <label class="col-xl-2 col-lg-2 col-form-label font-size-h4 text-left">حساب الأجرة</label>
                                <div class="col-lg-4 col-xl-4 text-left ">
                                    <input class="form-control" v-model="Supply.money_for_18">
                                </div>
                            </div>
                            <!--end::weight_18-->
                            <!--begin::weight_21-->
                            <div class="form-group row">
                                <label class="col-xl-2 col-lg-2 col-form-label font-size-h4 text-left">اضافة ذهب عيار ٢١</label>
                                <div class="col-lg-4 col-xl-4 text-left ">
                                    <input class="form-control" v-model="Supply.weight_amount_21">
                                </div>
                                <label class="col-xl-2 col-lg-2 col-form-label font-size-h4 text-left">حساب الأجرة</label>
                                <div class="col-lg-4 col-xl-4 text-left ">
                                    <input class="form-control" v-model="Supply.money_for_21">
                                </div>
                            </div>
                            <!--end::weight_21-->
                            <div class="col-md-12 text-center">
                                <button v-if="Mood =='edit'" class="btn btn-primary btn-lg">تعديل امر توريد</button>
                             </div>
                            <!--begin::payments_section-->

                            <payment-table :Payments="Supply.payments" :Mood="Mood" ></payment-table>
                            <!--end::payments_section-->

                            <div class="col-md-12 text-center">
                                <button v-if="Mood != 'edit'" class="btn btn-primary btn-lg">انشاء امر توريد</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
            <loading-spinner v-if="LoadingSpinner"></loading-spinner>

        </div>

</template>

<script>
    import PaymentTable from "./PaymentTable";
    export default {
        name: "CreateEditSupply",
        components: {PaymentTable},
        props:{
            Supplier:{},
            SentSupply:{},
            Mood : '',
        },
        data(){
            return {
                LoadingSpinner:false,
                Supply :{
                    weight_amount_18 : 0,
                    money_for_18:0,
                    weight_amount_21:0,
                    money_for_21:0,
                    payments:[],
                },
            }
        },
        created () {
          this.ManageSentSupply();
        },
        methods :{
            ManageSentSupply(){
                if(this.SentSupply != undefined){
                    this.Supplier = this.SentSupply.supplier;
                    for(const key in this.SentSupply){
                        if(key != 'supplier'){
                            this.Supply[key] = this.SentSupply[key];
                        }
                    }
                }
            },
            StoreNewSupply(){
                this.LoadingSpinner = true;
                let formData = new FormData();
                formData.append('supplier_id',this.Supplier.id);
                formData.append('weight_amount_18',this.Supply.weight_amount_18);
                formData.append('weight_amount_21',this.Supply.weight_amount_21);
                formData.append('money_for_18',this.Supply.money_for_18);
                formData.append('money_for_21',this.Supply.money_for_21);
                formData.append('payments',JSON.stringify(this.Supply.payments));
                formData.append('payments_length',this.Supply.payments.length);

                axios.post(route('AdminSupplies.store'),formData)
                    .then(res => {
                        console.log(res);
                        this.LoadingSpinner = false;
                        this.$swal.fire({
                            icon:'success',
                            title: 'تم انشاء امر توريد جديدة بنجاح',
                            text:'هل تريد اضافة امر توريد جديدة اخرة؟',
                            showCancelButton:true,
                            confirmButtonText: `اضافة امر توريد جديد`,
                            cancelButtonText: `غلق`,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                this.Supply = {
                                    weight_amount_18 : 0,
                                    weight_amount_21 : 0,
                                    money_for_18 : 0,
                                    money_for_21 : 0,
                                    payments:[],
                                };
                            } else if (result.isDismissed) {
                                window.location.href =  window.route('AdminSuppliers.index',this.Supplier.id);
                            }
                        })
                    }).catch(error => {
                        this.LoadingSpinner = false;
                        this.$swal({
                            title:'حدث خطأ يرجي اعادة المحاولة',
                            icon:'error',
                        })
                    })
            },
            UpdateSupplyData(){
                this.LoadingSpinner = true;
                let formData= new FormData();
                formData.append('_method',"PATCH");
                formData.append('weight_amount_18',this.Supply.weight_amount_18);
                formData.append('weight_amount_21',this.Supply.weight_amount_21);
                formData.append('money_for_18',this.Supply.money_for_18);
                formData.append('money_for_21',this.Supply.money_for_21);

                axios.post(route('AdminSupplies.update',this.Supply.id),formData)
                    .then(res => {
                        this.LoadingSpinner = false;
                        this.$swal({
                            icon:'success',
                            title:'تم تعديل البيانات بنجاح',
                            showConfirmButton: false,
                            timer: 800
                        })
                    }).catch(error => {
                        this.LoadingSpinner = false;
                        this.$swal({
                            title:'حدث خطأ يرجي اعادة المحاولة',
                            icon:'error',
                        })
                    })
            }
        }
    }
</script>

<style scoped>

</style>
