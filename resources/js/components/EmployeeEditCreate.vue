<template>
    <form @submit.prevent="$parent.WizardType == 'create' ? CreateNewEmployee() : UpdateEmployee() ">
        <h3 class="mb-10 font-weight-bold text-dark" v-if="$parent.WizardType == 'create'"> ادخال بيانات موظف جديد</h3>
        <h3 class="mb-10 font-weight-bold text-dark" v-if="$parent.WizardType == 'edit'"> تعديل بيانات موظف</h3>
        <!--begin::Input-->
        <div class="form-group fv-plugins-icon-container">
            <label>اسم الموظف</label>
            <input v-model="CurrentEmployee.name" type="text" class="form-control form-control-solid form-control-lg" name="name" placeholder="اسم الموظف" required>
        </div>
        <!--end::Input-->
        <!--begin::Input-->
        <div class="form-group">
            <label>الرقم القومي</label>
            <input v-model="CurrentEmployee.national_id" type="number" class="form-control form-control-solid form-control-lg" name="natonal_id"  placeholder="الرقم القومي للموظف" required>
        </div>
        <!--end::Input-->
        <!--begin::Input-->
        <div class="form-group">
            <label>رقم الهاتف</label>
            <input v-model="CurrentEmployee.phone" type="number" class="form-control form-control-solid form-control-lg" name="phone"  placeholder="رقم هاتف للموظف" required>
        </div>
        <!--end::Input-->
        <!--begin::Input-->
        <div class="form-group">
            <label>عدد القطع</label>
            <input v-model="CurrentEmployee.number_of_items" type="number" class="form-control form-control-solid form-control-lg" name="phone"  placeholder="رقم هاتف للموظف" required>
        </div>
        <!--end::Input-->
        <div class="row">
            <div class="col-xl-6">
                <!--begin::Input-->
                <div class="form-group fv-plugins-icon-container">
                    <label>الوزنة عيار ١٨</label>
                    <input v-model="CurrentEmployee.current_weight_18" :disabled="$parent.WizardType=='edit' ? true : false" type="number" value="0" step="0.001" class="form-control form-control-solid form-control-lg" name="current_weight_18" placeholder="الوزنة عيار ١٨">
                    <div class="fv-plugins-message-container"></div></div>
                <!--end::Input-->
            </div>
            <div class="col-xl-6">
                <!--begin::Input-->
                <div class="form-group fv-plugins-icon-container">
                    <label>الوزنة عيار ٢١</label>
                    <input v-model="CurrentEmployee.current_weight_21" :disabled="$parent.WizardType=='edit' ? true : false" type="number" value="0" step="0.001" class="form-control form-control-solid form-control-lg" name="current_weight_21" placeholder="الوزنة عيار ٢١">
                    <div class="fv-plugins-message-container"></div></div>
                <!--end::Input-->
            </div>
        </div>


        <!--begin::braceltes section-->
        <div v-if="CurrentEmployee.id == 1">
            <!--begin::Input-->
            <div class="form-group">
                <label>عدد قطع الغوايش</label>
                <input v-model="CurrentEmployee.bracelets_number_of_items" type="number" class="form-control form-control-solid form-control-lg" name="phone"  placeholder="عدد قطع الغوايش" required>
            </div>
            <!--end::Input-->
            <div class="row">
                <div class="col-xl-6">
                    <!--begin::Input-->
                    <div class="form-group fv-plugins-icon-container">
                        <label>وزنة الغوايش عيار ١٨</label>
                        <input v-model="CurrentEmployee.bracelets_current_weight_18	" :disabled="$parent.WizardType=='edit' ? true : false" type="number" value="0" step="0.001" class="form-control form-control-solid form-control-lg" name="current_weight_18" placeholder="وزن الغوايش عيار ١٨">
                        <div class="fv-plugins-message-container"></div></div>
                    <!--end::Input-->
                </div>
                <div class="col-xl-6">
                    <!--begin::Input-->
                    <div class="form-group fv-plugins-icon-container">
                        <label>وزنة الغوايش عيار ٢١</label>
                        <input v-model="CurrentEmployee.bracelets_current_weight_21" :disabled="$parent.WizardType=='edit' ? true : false" type="number" value="0" step="0.001" class="form-control form-control-solid form-control-lg" name="current_weight_21" placeholder="وزن الغوايش عيار ٢١">
                        <div class="fv-plugins-message-container"></div></div>
                    <!--end::Input-->
                </div>
            </div>
        </div>
        <!--end::braceltes section-->



        <div class="col-xl-12 justify-content-center text-center">
            <button v-if="$parent.WizardType == 'create'" class="btn btn-primary btn-lg">انشاء موظف</button>
            <button v-else class="btn btn-warning btn-lg">تعديل بيانات موظف</button>
        </div>
        <loading-spinner v-if="LoadingSpinner"></loading-spinner>

    </form>
</template>

<script>
    export default {
        name: "EmployeeEditCreate",
        props: {
            Employee:Object,
        },
        data(){
            return{
                'LoadingSpinner' : false,
                'CurrentEmployee':{},
            }
        },
        created(){
            this.CopyPropToDataEmployee();
        },
        methods:{
            CopyPropToDataEmployee(){
                // if it's create form
                if(this.Employee != null && this.Employee != undefined){
                    for (const property in this.Employee) {
                        this.CurrentEmployee[property] = this.Employee[property];
                    }
                }
                this.$forceUpdate();
            },
            CreateNewEmployee(){
              let formData = new FormData();
              formData.append('name',this.CurrentEmployee.name);
              formData.append('national_id',this.CurrentEmployee.national_id);
              formData.append('phone',this.CurrentEmployee.phone);
              formData.append('number_of_items',this.CurrentEmployee.number_of_items);
              if(this.CurrentEmployee.hasOwnProperty('bracelets_number_of_items') && this.CurrentEmployee.bracelets_number_of_items != '' && this.CurrentEmployee.bracelets_number_of_items != 0){
                    formData.append('bracelets_number_of_items',this.CurrentEmployee.bracelets_number_of_items);
              }
              if(this.CurrentEmployee.hasOwnProperty('current_weight_18') && this.CurrentEmployee.current_weight_18 != '' && this.CurrentEmployee.current_weight_18 != 0){
                  formData.append('weight_change','add_weight');
                  formData.append('current_weight_18',this.CurrentEmployee.current_weight_18);
              }
              if(this.CurrentEmployee.hasOwnProperty('current_weight_21') && this.CurrentEmployee.current_weight_21 != '' && this.CurrentEmployee.current_weight_21 != 0){
                  formData.append('weight_change','add_weight');
                  formData.append('current_weight_21',this.CurrentEmployee.current_weight_21);
              }
              if(this.CurrentEmployee.hasOwnProperty('bracelets_current_weight_18') && this.CurrentEmployee.bracelets_current_weight_18 != '' && this.CurrentEmployee.bracelets_current_weight_18 != 0){
                  formData.append('weight_change','add_weight');
                  formData.append('bracelets_current_weight_18',this.CurrentEmployee.bracelets_current_weight_18);
              }
              if(this.CurrentEmployee.hasOwnProperty('bracelets_current_weight_21') && this.CurrentEmployee.bracelets_current_weight_21 != '' && this.CurrentEmployee.bracelets_current_weight_21 != 0){
                  formData.append('weight_change','add_weight');
                  formData.append('bracelets_current_weight_21',this.CurrentEmployee.bracelets_current_weight_21);
              }
              this.LoadingSpinner = true;

              axios.post(route('AdminEmployees.store'),formData)
                  .then(({data}) => {
                    this.LoadingSpinner = false;
                  Swal.fire({
                      icon:'success',
                      title: 'تم انشاء الموظف بنجاح',
                      text:'هل تريد اضافة موظف اخر؟',
                      showCancelButton:true,
                      confirmButtonText: `اضافة موظف`,
                      cancelButtonText: `غلق`,
                  }).then((result) => {
                      /* Read more about isConfirmed, isDenied below */
                      if (result.isConfirmed) {
                          this.CurrentEmployee = {};
                          for (const property in this.CurrentEmployee) {
                              this.CurrentEmployee[property] = '';
                          }
                      } else if (result.isDismissed) {
                          this.CurrentEmployee.id = data.NewEmployee.id;
                          this.$emit('WizardTypeChanged','edit',this.CurrentEmployee);
                      }
                  })

              }).catch(error => {
                  this.LoadingSpinner = false;
                  console.log(error);
                  this.$swal({
                      title:'حدث خطأ يرجي راجعة البيانات ثم اعادة المحاولة',
                      icon:'error',
                  })
              })
            },
            UpdateEmployee(){
                let formData = new FormData();
                formData.append('_method',"PATCH");
                formData.append('name',this.CurrentEmployee.name);
                formData.append('national_id',this.CurrentEmployee.national_id);
                formData.append('phone',this.CurrentEmployee.phone);
                formData.append('number_of_items',this.CurrentEmployee.number_of_items);
                formData.append('bracelets_number_of_items',this.CurrentEmployee.bracelets_number_of_items);
                this.LoadingSpinner = true;
                axios.post(route('AdminEmployees.update',this.CurrentEmployee.id),formData)
                    .then(res => {
                        this.LoadingSpinner = false;

                        this.$swal({
                            icon:'success',
                            title:'تم تعديل البيانات بنجاح',
                            showConfirmButton: false,
                            timer: 800
                        })
                        this.$emit('EmployeeDataChanged',this.CurrentEmployee,false);
                    }).catch(error => {
                    this.LoadingSpinner = false;
                    console.log(error);
                        this.$swal({
                            title:'حدث خطأ تأكد من البيانات',
                            icon:'error',
                        })
                    })
            }
        },


    }
</script>

<style scoped>

</style>
