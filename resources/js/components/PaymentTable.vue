<template>
    <div class="py-10">
        <h5 class="font-size-h2 my-5">
            بيانات الدفعات
        </h5>

        <!----- begin::Payment info ------->
        <form @submit.prevent="Mood == 'edit' ? StoreAndAddPayment():AddPayment()" class="row justify-content-center">

                <div class="col-md-4">
                    <label>تنزيل ذهب عيار ١٨</label>
                    <input v-model="NewPayment.weight_amount_18" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label>تنزيل ذهب عيار ٢١</label>
                    <input v-model="NewPayment.weight_amount_21" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label>حساب الأجر</label>
                    <input v-model="NewPayment.price" class="form-control" required>
                </div>
                <button  class="btn btn-success btn-md mt-3 text-center">اضافة دفعة جديدة</button>
        </form>
        <!----- end::Payment info ------->

        <!----- begin::Payment table ------->
        <table v-if="Payments.length != 0" class="table table-head-custom table-vertical-center table-head-bg table-borderless my-5">
            <thead>
            <tr class="text-left">
                <th style="min-width: 40px">
                      <span class="text-dark-75">
                       تنزيل ذهب عيار ١٨
                    </span>

                </th>
                <th style="min-width: 40px">
                  <span class="text-dark-75">
                        تنزيل ذهب عيار ٢١
                    </span>
                </th>
                <th style="min-width: 40px">
                    <span class="text-dark-75">
                        حساب الأجر
                    </span>
                </th>
                <th style="min-width: 40px">
                    <span class="text-dark-75 text-center">

                    </span>
                </th>
            </tr>
            </thead>
            <tbody>
                <tr v-for="(Payment,index) in Payments" class="text-left">
                    <td>
                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">
                                                    {{Payment.weight_amount_18}}
                        </span>
                    </td>
                    <td>
                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">
                                                    {{Payment.weight_amount_21}}
                        </span>
                    </td>
                    <td>
                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">
                                                    {{Payment.price}}
                        </span>
                    </td>
                    <td>
                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg text-center cursor-pointer">
                                    <i class="la la-trash-alt icon-2x" @click="Payment.hasOwnProperty('id') ? DeleteAndRemovePayment(Payment,index):RemovePayment(index)"></i>
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
        <!----- end::Payment table ------->
        <loading-spinner v-if="LoadingSpinner"></loading-spinner>

    </div>
</template>

<script>
    export default {
        name: "PaymentTable",
        props:{
            Payments : [],
            Mood : '',
        },
        data(){
            return {
                LoadingSpinner:false,
                NewPayment : {
                  weight_amount_18: 0,
                  weight_amount_21: 0,
                  price: 0,
                },
            }
        },
        methods:{
            AddPayment(){
                this.Payments.push({...this.NewPayment});
                this.$swal({
                    title:'تم اضافة الدفعة',
                    icon:'success',
                })
            },
            RemovePayment(index){
                this.Payments.splice(index,1);
                this.$swal({
                    title:'تم اضافة الدفعة',
                    icon:'success',
                })
            },

            StoreAndAddPayment(){
                this.LoadingSpinner = true;
                let formData = new FormData();

                formData.append('supply_id',this.$parent.Supply.id);
                formData.append('weight_amount_18',this.NewPayment.weight_amount_18);
                formData.append('weight_amount_21',this.NewPayment.weight_amount_21);
                formData.append('price',this.NewPayment.price);

                axios.post(route('AdminPayments.store'),formData)
                    .then(({data}) => {
                        this.LoadingSpinner = false;
                        this.NewPayment.id = data.NewPayment.id;
                        this.Payments.push({...this.NewPayment});
                        this.$swal({
                            title:'تم اضافة الدفعة',
                            icon:'success',
                        })
                    }).catch(error => {
                        this.LoadingSpinner = false;
                        this.$swal({
                            title:'حدث خطأ يرجي اعادة المحاولة',
                            icon:'error',
                        })
                    })
            },
            DeleteAndRemovePayment(payment,index){
                this.LoadingSpinner = true;
                axios.delete(route('AdminPayments.delete',payment.id))
                    .then(res => {
                        this.LoadingSpinner = false;
                        this.Payments.splice(index,1);
                        this.$swal({
                            title:'تم حذف الدفعة',
                            icon:'success',
                        })
                    }).catch(error => {
                        this.LoadingSpinner = false;
                        this.$swal({
                            title:'حدث خطأ يرجي اعادة المحاولة',
                            icon:'error',
                        })
                    })
            }
        },
    }
</script>

<style scoped>

</style>
