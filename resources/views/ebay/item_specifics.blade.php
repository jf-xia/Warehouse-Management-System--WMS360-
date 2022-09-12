<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script>
    $('.select2').select2();
</script>


{{--<div class="row m-t-10">--}}
{{--    <div class="col-md-2">--}}
{{--        <label class="required">Item Specifics </label>--}}
{{--    </div>--}}
{{--    @isset($item_specifics['Recommendations']['NameRecommendation'])--}}
{{--    <div class="col-md-10">--}}
{{--        <div class="card">--}}
{{--            <div class="row px-2 py-3">--}}

{{--                    @foreach($item_specifics['Recommendations']['NameRecommendation'] as $item_specific)--}}
{{--                        <div class="col-md-12">--}}
{{--                            <h5></h5><span>(Write your value after the already inserted id and don't give '/' slash in your input value)</span><br>--}}
{{--                        </div>--}}
{{--                            @isset($item_specific['Name'])--}}
{{--                                <div class="col-md-6 m-t-15">--}}
{{--                                    <button class="btn btn-primary w-100">{{$item_specific['Name']}}--}}
{{--                                        @if($item_specific['ValidationRules']['UsageConstraint'] == 'Required')--}}
{{--                                            <strong>*</strong>--}}
{{--                                            @endif--}}
{{--                                    </button>--}}
{{--                                    <input type="text" class="form-control" name='item_specific[{{$item_specific['Name']}}]'>--}}
{{--                                </div>--}}
{{--                            @endisset--}}
{{--                    @endforeach--}}

{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    @endisset--}}
{{--</div>--}}






<div class="form-group row ">
    <label for="Category" class="col-md-2 col-form-label required">Item Specifies</label>
    @isset($item_specifics['Recommendations']['NameRecommendation'])
        <div class="col-md-10 wow pulse">


            <div class="col-md-12">
                {{--                                                        <h5></h5><span>(Write your value after the already inserted id and don't give '/' slash in your input value)</span><br>--}}
            </div>




            <div class="row d-flex justify-content-between">
                @foreach($item_specifics['Recommendations']['NameRecommendation'] as $index => $item_specific)
                    @php
                        $counter = 0;
                        if(isset($result[0]->attribute)){
                            foreach (\Opis\Closure\unserialize($result[0]->attribute) as $key => $attribute_array){
                            foreach ($attribute_array as $attribute => $terms_array){
                                if($key == $item_specific['Name']){
                                    $counter++;
                                }
                            }

                        }
                        }

                    @endphp
                    @if(isset($item_specific['Name']) && $counter==0)
                        <div class="col-md-4 mb-3">
                            <label style="font-weight: normal">{{$item_specific['Name']}}
                                @if($item_specific['ValidationRules']['UsageConstraint'] == 'Required')
                                    <strong>*</strong>
                                @endif
                            </label>
                            {{--                            Search our models: <input type="search" name="modelsearch" list="modelslist">--}}
                            <input type="search" class="form-control" list="modelslist{{$index}}"  name='item_specific[{{$item_specific['Name']}}]'>
                            @if(isset($item_specific['ValueRecommendation']))

                                <datalist id="modelslist{{$index}}">
                                    @foreach($item_specific['ValueRecommendation'] as $recommendation)
                                        @if(isset($recommendation['Value']))
                                            <option value="{{$recommendation['Value']}}">
                                        @endif
                                    @endforeach
                                </datalist>

                            @endif

                            {{--                            <input type="text" class="form-control" name='item_specific[{{$item_specific['Name']}}]'>--}}
                            {{--                        <select name='item_specific[{{$item_specific['Name']}}]' class="form-control select2">--}}
                            {{--                            <option value="">Select-{{$item_specific['Name']}}</option>--}}
                            {{--                            <option value="">ABC</option>--}}
                            {{--                            <option value="">BDC</option>--}}
                            {{--                            <option value="">BDF</option>--}}
                            {{--                            <option value="">ADE</option>--}}
                            {{--                        </select>--}}
                        </div>
                    @endif
                    @php
                        $counter = 0;
                    @endphp
                @endforeach
            </div>


        </div>

    @endisset
</div>
@isset($shop_categories['Store']['CustomCategories']['CustomCategory'])
    <div class="form-group row ">
        <label for="Category" class="col-md-2 col-form-label required">Shop Category</label>

        <div class="col-md-10 wow pulse">


            <div class="col-md-12">
                {{--                                                        <h5></h5><span>(Write your value after the already inserted id and don't give '/' slash in your input value)</span><br>--}}
            </div>


            <div class="row d-flex justify-content-between">
                <div class="col-md-4 mb-3">
                    <select name='store_id' class="form-control select2">
                        <option value=""> Select shop</option>
                        @if(isset($shop_categories['Store']['CustomCategories']['CustomCategory'][0]) && is_array($shop_categories['Store']['CustomCategories']['CustomCategory']))
                            @foreach($shop_categories['Store']['CustomCategories']['CustomCategory'] as $shop_category)
                                @if(isset($shop_category['ChildCategory']) && is_array($shop_category))
                                    @foreach($shop_category['ChildCategory'] as $child_category_1)
                                        @if(isset($child_category_1['ChildCategory']) && is_array($child_category_1['ChildCategory']))
                                            @foreach($child_category_1['ChildCategory'] as $child_category_2)
                                                @if(isset($child_category_2['CategoryID']))
                                                    <option value="{{$child_category_2['CategoryID']}}/{{$child_category_2['Name']}}">{{$shop_category['Name']}}>{{$child_category_1['Name']}}>{{$child_category_2['Name']}}</option>
                                                @endif
                                            @endforeach
                                        @else
                                            <option value="{{$child_category_1['CategoryID']}}/{{$child_category_1['Name']}}">{{$shop_category['Name']}}>{{$child_category_1['Name']}}</option>
                                        @endif
                                    @endforeach
                                @else
                                    <option value="{{$shop_category['CategoryID']}}/{{$shop_category['Name']}}">{{$shop_category['Name']}}</option>
                                @endif
                            @endforeach
                        @else
                            <option value="{{$shop_categories['Store']['CustomCategories']['CustomCategory']['CategoryID']}}/{{$shop_categories['Store']['CustomCategories']['CustomCategory']['Name']}}">{{$shop_categories['Store']['CustomCategories']['CustomCategory']['Name']}}</option>
                        @endif
                    </select>
                </div>
            </div>


        </div>

    </div>
@endisset

@isset($shop_categories['Store']['CustomCategories']['CustomCategory'])
    <div class="form-group row ">
        <label for="Category" class="col-md-2 col-form-label required">Shop Category 2</label>

        <div class="col-md-10 wow pulse">


            <div class="col-md-12">
                {{--                                                        <h5></h5><span>(Write your value after the already inserted id and don't give '/' slash in your input value)</span><br>--}}
            </div>


            <div class="row d-flex justify-content-between">
                <div class="col-md-4 mb-3">
                    <select name='store2_id' class="form-control select2">
                        <option value=""> Select shop 2</option>
                        @if(isset($shop_categories['Store']['CustomCategories']['CustomCategory'][0]) && is_array($shop_categories['Store']['CustomCategories']['CustomCategory']))
                            @foreach($shop_categories['Store']['CustomCategories']['CustomCategory'] as $shop_category)
                                @if(isset($shop_category['ChildCategory']) && is_array($shop_category['ChildCategory']))
                                    @foreach($shop_category['ChildCategory'] as $child_category_1)
                                        @if(isset($child_category_1['ChildCategory']) && is_array($child_category_1['ChildCategory']))
                                            @foreach($child_category_1['ChildCategory'] as $child_category_2)
                                                @if(isset($child_category_2['CategoryID']))
                                                    <option value="{{$child_category_2['CategoryID']}}/{{$child_category_2['Name']}}">{{$shop_category['Name']}}>{{$child_category_1['Name']}}>{{$child_category_2['Name']}}</option>
                                                @endif
                                            @endforeach
                                        @else
                                            <option value="{{$child_category_1['CategoryID']}}/{{$child_category_1['Name']}}">{{$shop_category['Name']}}>{{$child_category_1['Name']}}</option>
                                        @endif
                                    @endforeach
                                @else
                                    <option value="{{$shop_category['CategoryID']}}/{{$shop_category['Name']}}">{{$shop_category['Name']}}</option>
                                @endif
                            @endforeach
                        @else
                            <option value="{{$shop_categories['Store']['CustomCategories']['CustomCategory']['CategoryID']}}/{{$shop_categories['Store']['CustomCategories']['CustomCategory']['Name']}}">{{$shop_categories['Store']['CustomCategories']['CustomCategory']['Name']}}</option>
                        @endif
                    </select>
                </div>
            </div>


        </div>


    </div>
@endisset


<div class="form-group row ">
    <label for="Category" class="col-md-2 col-form-label required">Condition</label>
    @isset($conditions['Category']['ConditionValues']['Condition'])
        <div class="col-md-10 wow pulse">

            <div class="col-md-12">
                {{--                                                        <h5></h5><span>(Write your value after the already inserted id and don't give '/' slash in your input value)</span><br>--}}
            </div>


            <div class="row d-flex justify-content-between">
                @if(isset($conditions['Category']['ConditionValues']['Condition']))
                    <div class="col-md-4 mb-3">
                        <select name='condition_id' class="form-control select2" required>
                            <option value="">Select Condition</option>
                            @foreach($conditions['Category']['ConditionValues']['Condition'] as $condition)
                                <option value="{{$condition['ID']}}/{{$condition['DisplayName']}}">{{$condition['DisplayName']}}/{{$condition['ID']}}</option>
                            @endforeach

                        </select>
                    </div>
                @else
                    condition not available
                @endif
            </div>


        </div>

    @endisset
</div>

<div class="form-group row">
    <label for="post_code" class="col-md-2 col-form-label ">Condition Description</label>
    <div class="col-md-10 wow pulse">
        <textarea class="col-10" name="condition_description"></textarea>
    </div>
</div>






