<link rel="stylesheet" href="{{asset('assets/plugins/summernote/summernote-bs4.css')}}"  />
<div class="col-md-2"></div>
    @foreach($attribute_array as $key => $value)
    <div  class="col-md-2">
        <div class="text-center"> <label>{!! \App\Attribute::findOrFail($key)->attribute_name !!}</label></div>
        <div>
            <select name="a{{$key}}" id="a{{$key}}" class="form-control" required >
                <option>select</option>
                @foreach($value as $key => $value)
                <option>{{$value['name']}}</option>
                @endforeach
            </select>
        </div>
    </div>
    @endforeach

    <div class="form-group row m-t-30">
        <div class="col-md-3"> </div>
        <div class="col-md-3">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="customCheck1">
                <label class="custom-control-label" for="customCheck1">Notification Status</label>
            </div>
        </div>
        <div class="col-md-3"> </div>
    </div>


<div class="form-group row m-t-40">
{{--    <div class="col-md-1"></div>--}}
    <div class="col-md-3">
        <div class="text-center"> <label class="required">SKU</label></div>
        <div>
            <input type="text" name="sku" class="form-control" required data-parsley-maxlength="30" id="sku" placeholder="">
            <input type="button" onclick="generate_sku();" style="padding: 2px 37px 2px 37px; border: 1px solid #ccc; border-radius: 3px;" class="m-t-10" value="Generate SKU">
        </div>
    </div>

    <div class="col-md-3">
        <div class="text-center"> <label class="p-v-label">EAN</label></div>
        <div>
            <input type="text" name="ean_no" class="form-control" maxlength="13" pattern="[0-9]{13}" id="ean_no" placeholder="" onkeyup="exist_ean_no_check(this.value);">
            <span id="ean_no_exist_msg"></span>
        </div>
    </div>



    <div class="col-md-3">
        <div class="text-center"> <label class="required p-v-label">Regular price</label></div>
        <div>
            <input type="text" name="regular_price" value="{{$product_draft_result->regular_price}}" class="form-control" required data-parsley-maxlength="30" id="" placeholder="">
        </div>
    </div>
    <div class="col-md-3">
        <div class="text-center"> <label class="required p-v-label">Sale Price</label></div>
        <div>
            <input type="text" name="sale_price" value="{{$product_draft_result->sale_price}}" class="form-control" required data-parsley-maxlength="30" id="" placeholder="">
        </div>
    </div>

    <div class="col-md-3">
        <div class="text-center"> <label class="p-v-label">Cost Price</label></div>
        <div>
            <input type="text" name="cost_price" value="{{$product_draft_result->cost_price}}" class="form-control" data-parsley-maxlength="30" id="" placeholder="">
        </div>
    </div>

    <div class="col-md-3">
        <div class="text-center"> <label class="p-v-label">Product Code</label></div>
        <div>
            <input type="text" name="product_code" value="{{$product_draft_result->product_code}}" class="form-control" data-parsley-maxlength="30" id="product_code" placeholder="">
        </div>
    </div>

    <div class="col-md-3">
        <div class="text-center"> <label class="p-v-label">Color Code</label></div>
        <div>
            <input type="text" name="color_code" value="{{$product_draft_result->color_code}}" class="form-control" data-parsley-maxlength="30" id="color_code" placeholder="">
        </div>
    </div>


    <div class="col-md-3">
        <div class="text-center"> <label class="p-v-label">low Quantity</label></div>
        <div>
            <input type="text" name="low_quantity" class="form-control" data-parsley-maxlength="30" id="" placeholder="">
        </div>
    </div>

{{--    <div class="col-md-1"></div>--}}

   <div class="col-md-8 com-sm-12" style="margin-left: 11rem; margin-top: 1rem;">
       <label>Description :</label>
       <textarea name="description" class="form-control summernote"></textarea>
{{--       <div class="summernote">--}}
{{--           <h3>Hello Summernote</h3>--}}
{{--       </div>--}}
   </div>
</div> <!--form-group end-->

    <script type="text/javascript">
        function generate_sku() {

            var data = $('#product-dropdown').val()+'_';
            // var data = '';

            if(document.getElementById("a5") != null){
                if(document.getElementById("a5").value != 'select') {
                    var attribute1 = document.getElementById("a5").value.split(' ').join('_');
                    var data = data + attribute1 + '_';
                }
            }
            if(document.getElementById("a6") != null){
                if(document.getElementById("a6").value != 'select') {
                    var attribute2 = document.getElementById("a6").value.split(' ').join('_');
                    var data = data + attribute2 + '_';
                }
            }
            if(document.getElementById("a7") != null){
                if(document.getElementById("a7").value != 'select') {
                    var attribute3 = document.getElementById("a7").value.split(' ').join('_');
                    var data = data + attribute3 + '_';
                }
            }
            if(document.getElementById("a8") != null){
                if(document.getElementById("a8").value != 'select') {
                    var attribute4 = document.getElementById("a8").value.split(' ').join('_');
                    var data = data + attribute4 + '_';
                }
            }
            if(document.getElementById("a9") != null){
                if(document.getElementById("a9").value != 'select') {
                    var attribute5 = document.getElementById("a9").value.split(' ').join('_');
                    var data = data + attribute5 + '_';
                }
            }
            if(document.getElementById("a10") != null){
                if(document.getElementById("a10").value != 'select') {
                    var attribute6 = document.getElementById("a10").value.split(' ').join('_');
                    var data = data + attribute6 + '_';
                }
            }
            if(document.getElementById("a11") != null){
                if(document.getElementById("a11").value != 'select') {
                    var attribute7 = document.getElementById("a11").value.split(' ').join('_');
                    var data = data + attribute7 + '_';
                }
            }
            if(document.getElementById("a12") != null){
                if(document.getElementById("a12").value != 'select') {
                    var attribute8 = document.getElementById("a12").value.split(' ').join('_');
                    var data = data + attribute8 + '_';
                }
            }
            if(document.getElementById("a13") != null){
                if(document.getElementById("a13").value != 'select') {
                    var attribute9 = document.getElementById("a13").value.split(' ').join('_');
                    var data = data + attribute9 + '_';
                }
            }
            if(document.getElementById("a14") != null){
                if(document.getElementById("a14").value != 'select') {
                    var attribute10 = document.getElementById("a14").value.split(' ').join('_');
                    var data = data + attribute10 + '_';
                }
            }
            data = data.replace(/_\s*$/, "");
            document.getElementById("sku").value = data;

        }


        // <!-- summernote--->

        jQuery(document).ready(function(){

            $('.summernote').summernote({
                height: 250,                 // set editor height
                minHeight: null,             // set minimum height of editor
                maxHeight: null,             // set maximum height of editor
                focus: false                 // set focus to editable area after initializing summernote
            });

            $('.inline-editor').summernote({
                airMode: true
            });

        });

        function exist_ean_no_check(ean_no) {
            console.log(ean_no);
            if(ean_no.length === 0){
                $('#ean_no_exist_msg').hide();
                return false;
            }
            $.ajax({
                type:"POST",
                url: "{{url('exist-ean-no-check')}}",
                data: {
                    "_token" : "{{csrf_token()}}",
                    "ean_no" : ean_no
                },
                success: function (response) {
                    console.log(response.data);
                    if(response.data !== 2){
                        $('#ean_no_exist_msg').show();
                        document.getElementById('ean_no_exist_msg').innerHTML = response.data;
                        document.getElementById("sendBtn").disabled = true;
                    }else{
                        $('#ean_no_exist_msg').hide();
                        document.getElementById("sendBtn").disabled = false;
                    }
                }

            });
        }

        function attribute_check() {
            if(document.getElementById("a5")){
                if(document.getElementById("a5").value != 'select'){
                    return true;
                }
            }
            if(document.getElementById("a6")){
                if(document.getElementById("a6").value != 'select'){
                    return true;
                }
            }
            if(document.getElementById("a7")){
                if(document.getElementById("a7").value != 'select'){
                    return true;
                }
            }
            if(document.getElementById("a8")){
                if(document.getElementById("a8").value != 'select'){
                    return true;
                }
            }
            if(document.getElementById("a9")){
                if(document.getElementById("a9").value != 'select'){
                    return true;
                }
            }
            if(document.getElementById("a10")){
                if(document.getElementById("a10").value != 'select'){
                    return true;
                }
            }
            if(document.getElementById("a11")){
                if(document.getElementById("a11").value != 'select'){
                    return true;
                }
            }
            if(document.getElementById("a12")){
                if(document.getElementById("a12").value != 'select'){
                    return true;
                }
            }
            if(document.getElementById("a13")){
                if(document.getElementById("a13").value != 'select'){
                    return true;
                }
            }
            if(document.getElementById("a14")){
                if(document.getElementById("a14").value != 'select'){
                    return true;
                }
            }else{
                swal("Warning","Please select a variation","warning");
                return false;
                // alert('Select a variation');
                // event.preventDefault();
            }

        }

    </script>



