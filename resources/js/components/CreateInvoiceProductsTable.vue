<template>
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
                <tbody >
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
                        <td v-if="(!IsFromBuyerProducts && !product.is_from_buyer) && !PrintingMood " style="width:250px;text-align:center">
                            <v-select v-if="!product.is_bracelet" :required="true" v-model="product.owner_employee" :label="owner_employee" :options="AvailableEmployeesWithPatreena" :reduce="owner_employee => owner_employee.id" ></v-select>
                            <b v-if="!product.is_bracelet" class="pt-5">او</b>
                            <br>
                            <b class="text-bold">غويشة</b>
                            <input v-model="product.is_bracelet" type="checkbox" >
                        </td>
                    </tr>
                </tbody>

            </table>
        </div>


    </div>

</template>

<script>
    export default {
        name: "ProductsAccordion",
        props:{
            products:[],
            AvailableEmployeesWithPatreena:[],
            IsFromBuyerProducts : false,
        },
        data(){
            return {
                PrintingMood:false,
            }
        },
        methods : {
            PropagateToParent(product,index,is_from_buyer = null){
                    if(is_from_buyer !== null){
                        product.is_from_buyer ? product.is_from_buyer = false : product.is_from_buyer = true;
                    }
                        this.$emit('ProductChanged',product,index);

            },
            RemoveProduct(product,index){

                    this.$emit('productRemoved',product,index);
            }

        }
    }
</script>

<style scoped>

</style>
