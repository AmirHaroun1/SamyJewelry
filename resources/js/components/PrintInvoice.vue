<template>
    <div id="printable" v-if="PrintingMood">
        <h1 class="text-center">
            <p id="invoice_title" class="editable-area invoice-name">فاتورة</p>
        </h1>
        <h5 class="invoice_type text-center">Samy Jewelry</h5>
        <h5 class="invoice_type text-center mt-5 text-bold">١١٥ شارع خلوصى - شبرا مصر ، ت : ٢٢٠٥٥٥٤٠ - ٠١٢٢٩٦٠٦٢٥٨</h5>
        <!--- begin :: seller info ------>
        <div class="invoice-info rtl text-right">
            البائع :
            <b v-if="Invoice != null">{{Invoice.seller_name}}</b>
        </div>
        <!--- end :: seller info ------>
        <br>
        <br>
        <!--- begin :: created_At info ------>
        <div class="invoice-info text-right mt-3">
            تاريخ الفاتورة :
            <b v-if="Invoice != null">{{formatCreatedAt(Invoice.created_at)}}</b>
        </div>
        <!--- end :: created_At info ------>
        <br>
        <br>
        <br>
        <br>
        <!--- begin ::sold products info ------>
        <div class="mt-3 ">
             <b class="text-right rtl">المنتجات :</b>
            <br>
            <br>
            <table style="width:100%" class="rtl">
                <!------ begin::heading-------->
                <tr style="background-color: #e5e5e5">
                    <th rowspan="2">البيان</th>
                    <th rowspan="2">العدد</th>
                    <th rowspan="2">عيار</th>
                    <th colspan="2" class="text-center">الجرامات</th>
                    <th rowspan="2">السعر</th>

                </tr>
                <tr style="background-color: #e5e5e5">

                    <th>ملى</th>
                    <th>جرام</th>

                </tr>
                <!------ end::heading-------->

                <tr v-if="!product.product_details.is_from_buyer" v-for="product in Invoice.products">
                    <td>{{product.name}}</td>
                    <td>{{product.product_details.number_of_items}}</td>
                    <td>{{product.product_details.weight_type}}</td>


                    <td>{{formatWeight(product.product_details.weight,'MilliGrams')}}</td>
                    <td>{{formatWeight(product.product_details.weight,'grams')}}</td>

                    <td>
                        {{formatPrice(product.product_details.total_price)}}
                    ج.م
                    </td>
                </tr>

            </table>
        </div>
        <!--- end :: sold products info ------>

        <!--- begin ::from_buyer_products products info ------>
        <div class="mt-15" v-if="Invoice.actual_price != Invoice.total_price">
            <b class="text-right rtl">مبادلة كسر :</b>
            <br>
            <br>
            <table style="width:100%" class="rtl">
                <!------ begin::heading-------->
                <tr style="background-color: #e5e5e5">
                    <th rowspan="2">البيان</th>
                    <th rowspan="2">العدد</th>
                    <th rowspan="2">عيار</th>
                    <th colspan="2" class="text-center">الجرامات</th>
                    <th rowspan="2">السعر</th>

                </tr>
                <tr style="background-color: #e5e5e5">


                    <th>ملى</th>
                    <th>جرام</th>

                </tr>
                <!------ end::heading-------->
                <tr v-if="product.product_details.is_from_buyer" v-for="product in Invoice.products">
                    <td>{{product.name}}</td>
                    <td>{{product.product_details.number_of_items}}</td>
                    <td>{{product.product_details.weight_type}}</td>


                    <td>{{formatWeight(product.product_details.weight,'MilliGrams')}}</td>
                    <td>{{formatWeight(product.product_details.weight,'grams')}}</td>

                    <td>{{formatPrice(product.product_details.total_price)}}
                        ج.م
                    </td>
                </tr>

            </table>
        </div>
        <!--- end ::from_buyer_products info ------>

        <!--- begin ::invoice summary info ------>
            <div>
                <h5 class="invoice_total text-right rtl mr-7 py-5">الأجمالى :
                {{formatPrice(Invoice.total_price)}}
                    ج.م
                </h5>
                <hr>
                <h5 class="invoice_total text-right rtl mr-7 mt-5 py-5 paddingAdjust">قيمة المنتجات :
                {{formatPrice(Invoice.actual_price)}}
                    ج.م
                </h5>
                <hr>
                <h5 class="invoice_total text-right rtl mr-7 mt-5 py-5 paddingAdjust">قيمة الكسر :
                {{formatPrice(Invoice.actual_price - Invoice.total_price)}}
                    ج.م
                </h5>
                <hr>
                <h5 class="invoice_total text-right rtl mr-7 mt-5 py-5 paddingAdjust">المدفوع فيزا :
                {{formatPrice(Invoice.paid_in_visa)}}
                    ج.م
                </h5>
                <hr>
                <h5 class="invoice_total text-right rtl mr-7 mt-5 py-5 paddingAdjust">المدفوع كاش :
                {{formatPrice(Invoice.paid_in_cache)}}
                    ج.م
                </h5>
            </div>
        <!--- end ::invoice summary info ------>



    </div>
</template>

<script>
    import { Printd } from 'printd'
    export default {
        name: "PrintInvoice",
        props :{
            'Invoice':{},
        },
        data(){
            return {
                PrintingMood: false,
            }
        },
        methods : {
            formatCreatedAt(date) {
                return moment(date).format(" H:mm , DD - MM - YYYY");
            },
            formatWeight(value,type){
                let x = value.toString().split('.');
                if(type == 'grams'){
                    return    x[0] != undefined ?  x[0] :  0;
                }else{
                    return x[1] != undefined ?  x[1] :  0;
                }
            },
            formatPrice(value) {
                if(value == undefined){
                    return 0;
                }
                if(value < 0){
                    value =  -1 * value;
                }
                let val = (value/1).toFixed(2).replace('.', ',')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "")
            },
            generatePdf(){
                this.PrintingMood = true;
                const d = new Printd();
                const styles = [
                    'body{height:5px}',
                    '.text-center{text-align: center;}',
                    '.mt-5{margin-top: 5px;}',
                    '.mt-3{margin-top: 3px;}',
                    '.mt-15{margin-top: 15px;}',
                    '.mr-7{padding-right: 7px;}',
                    '.py-5{padding-top: 5px;padding-bottom:5px}',
                    '.rtl{direction: rtl;}',
                    '.text-right{float: right;}',
                    '.invoice_title {color: black;}',
                    'table{font-family: arial, sans-serif;border-collapse: collapse;width: 100%;}',
                    'td, th{border: 1px solid #dddddd;text-align:right;padding: 8px;}',
                    '.invoice_total{width:100%;background-color:  #e5e5e5}',
                    '.paddingAdjust{margin-top:-19px}'
                ]
                setTimeout(()=>{
                    d.print( document.getElementById('printable'), styles );

                    this.PrintingMood = false;
                },1000);

            }
        }
    }
</script>

<style scoped>

</style>
