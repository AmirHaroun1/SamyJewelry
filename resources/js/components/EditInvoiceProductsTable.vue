<template>
    <div>
        <div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col" style="width:150px">عدد القطع</th>
                        <th scope="col">وصف المنتج</th>
                        <th scope="col">العيار</th>
                        <th scope="col" style="width:130px">الوزن الكلى</th>
                        <th scope="col" style="width:130px">السعر الكلى</th>
                        <th  scope="col" style="width:250px" v-if="!PrintingMood && !IsFromBuyerProducts">من عهدة</th>
                    </tr>
                    </thead>
                    <tbody>
                     <tr v-for="(product,index) in products">
                        <th v-if="(!IsFromBuyerProducts && !product.is_from_buyer) || (IsFromBuyerProducts && product.is_from_buyer)" scope="row">
                            <h6 class="px-3 text-dark-75 ">
                                {{product.name}}
                                <i @click="RemoveProduct(product,index)" class="flaticon2-delete icon-xs text-danger mr-3 text-sm text-right" v-if="!PrintingMood"></i>
                            </h6>
                        </th>
                        <td v-if="(!IsFromBuyerProducts && !product.is_from_buyer) || (IsFromBuyerProducts && product.is_from_buyer)" style="width:130px">
                            <input  type="number" min="1" v-model="product.number_of_items" class="input-table form-control"  required>
                        </td>
                        <td v-if="(!IsFromBuyerProducts && !product.is_from_buyer) || (IsFromBuyerProducts && product.is_from_buyer)">
                            <textarea v-model="product.description" class="input-table form-control"></textarea>
                        </td>
                        <td v-if="(!IsFromBuyerProducts && !product.is_from_buyer) || (IsFromBuyerProducts && product.is_from_buyer)">
                            <input type="text" v-model="product.weight_type" v-if="PrintingMood" class="input-table form-control">
                            <select v-else @change="PropagateToParent(product,index)" v-model="product.weight_type" class="input-table form-control"  required>
                                <option value="18" selected="selected">18</option>
                                <option value="21">21</option>
                            </select>

                        </td>
                        <td v-if="(!IsFromBuyerProducts && !product.is_from_buyer) || (IsFromBuyerProducts && product.is_from_buyer)" style="width:130px">
                            <input  v-model="product.weight" class="input-table form-control" @input="PropagateToParent(product,index)" type="number" min="0.5" step="0.01" required>
                        </td>
                        <td v-if="(!IsFromBuyerProducts && !product.is_from_buyer) || (IsFromBuyerProducts && product.is_from_buyer)">
                            <input @input="PropagateToParent(product,index)" type="number" min="0" step="0.01" v-model="product.total_price" class="input-table form-control"  >
                        </td>
                        <td v-if="( ( (!IsFromBuyerProducts && !product.is_from_buyer)  && !PrintingMood ) )" style="width:250px;text-align:center">

                            <v-select v-if="!product.is_bracelet" :required="true" v-model="product.owner_employee" :label="owner_employee" :options="AvailableEmployeesWithPatreena" :reduce="owner_employee => owner_employee.id" ></v-select>
                            <b v-if="!product.is_bracelet && !product.hasOwnProperty('products_invoices_id')">او</b>
                            <br>
                            <b v-if="product.is_bracelet || !product.hasOwnProperty('products_invoices_id') " class="text-bold">غويشة</b>
                            <input v-if="product.is_bracelet || !product.hasOwnProperty('products_invoices_id')" v-model="product.is_bracelet" type="checkbox" >
                        </td>
                        <td v-if="( (!IsFromBuyerProducts && !product.is_from_buyer) || (IsFromBuyerProducts && product.is_from_buyer) ) && (!product.hasOwnProperty('products_invoices_id'))">
                            <button class="btn btn-info btn-sm mt-4" @click="AddProduct(product,index)">اضافة</button>
                        </td>
                    </tr>
                    </tbody>

                </table>
            </div>


        </div>

        <loading-spinner v-if="LoadingSpinner"></loading-spinner>

    </div>

</template>

<script>
    export default {
        name: "EditInvoiceProductsAccordion",
        props:{
            products:[],
            AvailableEmployeesWithPatreena:[],
            IsFromBuyerProducts:false,
        },
        data () {
            return {
                LoadingSpinner : false,
                TempProduct: {},
            }
        },
        methods : {
            PropagateToParent(product,index,is_from_buyer = null){
                if(is_from_buyer !== null){
                    product.is_from_buyer ? product.is_from_buyer = false : product.is_from_buyer = true;
                }
                this.$emit('ProductChanged',product,index);
            },
            AddProduct(product,index){
                if(product.hasOwnProperty('is_from_buyer') && product.is_from_buyer){
                    product.owner_employee = ''
                }
                if(product.number_of_items < 0 || product.weight < 0 || product.total_price < 0){
                    this.$swal({
                        title:'حدث خطأ يرجي اعادة المحاولة',
                        icon:'error',
                    })
                }else{
                    let formData = new FormData();
                    formData.append('invoice_id',this.$parent.Invoice.id);
                    formData.append('invoice_seller_id',this.$parent.Invoice.employee_id);
                    formData.append('invoice_total_price',this.$parent.Invoice.total_price);
                    formData.append('invoice_actual_price',this.$parent.Invoice.actual_price);
                    formData.append('invoice_total_weight_21',this.$parent.Invoice.total_weight_21);
                    formData.append('invoice_total_weight_18',this.$parent.Invoice.total_weight_18);
                    formData.append('invoice_from_buyer_total_weight_21',this.$parent.Invoice.from_buyer_total_weight_21);
                    formData.append('invoice_from_buyer_total_weight_18',this.$parent.Invoice.from_buyer_total_weight_18);
                    if(product.hasOwnProperty('owner_employee') && product.owner_employee != this.$parent.Invoice.employee_id && product.owner_employee != '' && product.owner_employee != null && product.owner_employee != undefined) {
                        formData.append('product_owner_employee',product.owner_employee);
                    }
                    formData.append('product_is_from_buyer',product.is_from_buyer ? 1: 0);
                    formData.append('product_id',product.id);
                    formData.append('product_number_of_items',product.number_of_items);
                    formData.append('product_is_bracelet',product.is_bracelet ? 1:0);
                    formData.append('product_description',product.description == '' ? "لا يوجد" : product.description);
                    formData.append('product_total_price',product.total_price);
                    formData.append('product_weight',product.weight);
                    formData.append('product_weight_type',product.weight_type);
                    this.LoadingSpinner = true;
                    axios.post(route('AdminInvoices.AddProduct'),formData)
                        .then(({data}) => {
                            this.LoadingSpinner = false;
                            console.log(data);
                            this.$set(product,'products_invoices_id',data.AddedProduct_invoices_id[0].id );
                            this.$parent.SentInvoice.products.push({
                                id : product.id,
                                name : product.name,
                                product_details : {
                                    id: product.products_invoices_id,
                                    is_bracelet: product.is_bracelet,
                                    number_of_items: product.number_of_items,
                                    description: product.description,
                                    total_price: product.total_price,
                                    weight: product.weight,
                                    weight_type: product.weight_type,
                                    owner_employee : product.owner_employee,
                                    is_from_buyer : product.is_from_buyer
                                }
                            });
                            this.$swal({
                                title:'تم اضافة المنتج',
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
            EditProduct(product,index){
            },
            RemoveProduct(product,index){
                if(product.hasOwnProperty('products_invoices_id')){
                    this.$parent.SentInvoice.products.forEach(OriginalProd => {
                        if( OriginalProd.product_details.id == product.products_invoices_id ){
                            this.TempProduct.is_from_buyer = OriginalProd.product_details.hasOwnProperty('is_from_buyer') ? OriginalProd.product_details.is_from_buyer : 0 ;
                            this.TempProduct.owner_employee = OriginalProd.product_details.hasOwnProperty('owner_employee') ? OriginalProd.product_details.owner_employee : '';
                            this.TempProduct.number_of_items = OriginalProd.product_details.number_of_items;
                            this.TempProduct.is_bracelet = OriginalProd.product_details.is_bracelet;
                            this.TempProduct.weight = OriginalProd.product_details.weight;
                            this.TempProduct.weight_type = OriginalProd.product_details.weight_type;
                            this.TempProduct.products_invoices_id = OriginalProd.product_details.id;
                            this.TempProduct.product_id = OriginalProd.product_details.product_id;
                            return false;
                        }
                    });
                    let formData= new FormData();
                    formData.append('_method',"DELETE");
                    formData.append('is_form_buyer',this.TempProduct.is_from_buyer ? 1 : 0);
                    formData.append('is_bracelet',this.TempProduct.is_bracelet);
                    if(this.TempProduct.owner_employee != this.$parent.Invoice.employee_id && this.TempProduct.owner_employee != '' && this.TempProduct.owner_employee != null && this.TempProduct.owner_employee != undefined){
                        formData.append('owner_employee',this.TempProduct.owner_employee ? this.TempProduct.owner_employee : '');
                    }
                    formData.append('seller_id',this.$parent.Invoice.employee_id);
                    formData.append('number_of_items',this.TempProduct.number_of_items);
                    formData.append('weight',this.TempProduct.weight);
                    formData.append('weight_type',this.TempProduct.weight_type);
                    formData.append('products_invoices_id',this.TempProduct.products_invoices_id);
                    formData.append('invoice_id',this.$parent.Invoice.id);
                    formData.append('product_id',this.TempProduct.product_id);

                    this.$emit('productRemoved',product,index);

                    formData.append('invoice_total_price',this.$parent.Invoice.total_price);
                    formData.append('invoice_actual_price',this.$parent.Invoice.actual_price);
                    formData.append('invoice_total_weight_18',this.$parent.Invoice.total_weight_18);
                    formData.append('invoice_total_weight_21',this.$parent.Invoice.total_weight_21);
                    formData.append('invoice_from_buyer_total_weight_18',this.$parent.Invoice.from_buyer_total_weight_18);
                    formData.append('invoice_from_buyer_total_weight_21',this.$parent.Invoice.from_buyer_total_weight_21);
                    this.LoadingSpinner = true;
                    axios.post(route('AdminInvoices.DeleteProduct'),formData)
                        .then(res => {
                            this.LoadingSpinner = false;
                            console.log(res);
                            this.$swal({
                                title:'تم حذف المنتج',
                                icon:'success',
                            })
                        }).catch(error => {
                        this.LoadingSpinner = false;
                        console.log(error);
                        this.$swal({
                                title:'حدث خطأ يرجي اعادة المحاولة',
                                icon:'error',
                            })
                        })
                    this.TempProduct = {};
                }else{
                    this.$emit('productRemoved',product,index);
                    this.$swal({
                        title:'تم حذف المنتج',
                        icon:'success',
                    })
                }
            },
            ConvertToPositive(value){
                if(value < 0){
                    return -1 * value;
                }
            }
        }
    }
</script>

<style scoped>

</style>
