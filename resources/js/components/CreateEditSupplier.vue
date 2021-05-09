<template>
    <div class="container py-25">
        <div class="card card-custom">
            <div class="card-header">
                <h3 class="card-title" v-if="CreateMood">
                    اضافة مورد جديد
                </h3>
                <h3 class="card-title" v-else>
                    تعديل بيانات مورد
                </h3>
            </div>
            <form class="form" @submit.prevent="CreateMood ? StoreNewSupplier() : UpdateNewSupplier()">
                <div class="card-body">
                    <div class="row">
                        <div :class="CreateMood ? 'col-xl-6' : 'col-xl-12'">
                            <div class="row">
                                <label class="col-2 col-form-label">الأسم : </label>
                                <div class="col-10">
                                    <input v-model="supplier.name" class="form-control" type="text" required>
                                </div>
                            </div>
                            <div class="row my-4">
                                <label class="col-2 col-form-label">رقم الهاتف : </label>
                                <div class="col-10">
                                    <input v-model="supplier.phone" class="form-control" type="text" required>
                                </div>
                            </div>
                            <div class="row my-4">
                                <label class="col-2 col-form-label">رقم الهاتف 2 : </label>
                                <div class="col-10">
                                    <input v-model="supplier.phone2" class="form-control" type="text">
                                </div>
                            </div>

                            <div class="row my-5 ">
                                <div class="col-lg-12 text-center ">
                                    <button v-if="CreateMood" class="btn btn-primary">انشاء</button>
                                    <button v-else class="btn btn-warning">تعديل</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
        <loading-spinner v-if="LoadingSpinner"></loading-spinner>

    </div>
</template>

<script>
    export default {
        name: "CreateSupplier",
        data(){
            return{
                supplier:{},
                LoadingSpinner:false,
            }
        },
        props:{
          CreateMood :'',
            SentSupplier:{},
        },
        created (){
          this.ManageDataBetweenSentAndCurrent();
        },
        methods:{
            ManageDataBetweenSentAndCurrent(){
              if(!this.CreateMood){
                  for(const key in this.SentSupplier){
                      this.supplier[key] = this.SentSupplier[key];
                  }
              }
            },
            StoreNewSupplier(){
                this.LoadingSpinner = true;
                let formData = new FormData();
                formData.append('name',this.supplier.name);
                formData.append('phone',this.supplier.phone);

                formData.append('phone2',this.supplier.hasOwnProperty('phone2') ? this.supplier.phone2: '');

                axios.post(route('AdminSuppliers.store'),formData)
                    .then(res => {
                        this.LoadingSpinner = false;
                        window.location.href =  window.route('AdminSuppliers.index');
                    }).catch(error=>{
                         this.LoadingSpinner = false;
                        this.$swal({
                            title:'حدث خطأ يرجي اعادة المحاولة',
                            icon:'error',
                        })
                    })
            },
            UpdateNewSupplier(){
                let formData = new FormData();
                formData.append('_method',"PATCH");
                formData.append('name',this.supplier.name);
                formData.append('phone',this.supplier.phone);
                formData.append('phone2',this.supplier.hasOwnProperty('phone2') ? this.supplier.phone2: '');
                this.LoadingSpinner = true;
                axios.post(route('AdminSuppliers.update',this.supplier.id),formData)
                    .then(res=>{
                        this.LoadingSpinner = false;
                        this.$swal({
                            icon:'success',
                            title:'تم التعديل بنجاح',
                            showConfirmButton: false,
                            timer: 1000
                        })
                    }).catch(error=>{
                        this.$swal({
                            title:'حدث خطأ تأكد من البيانات',
                            icon:'error',
                        })
                    })
            },
        }
    }
</script>

<style scoped>

</style>
