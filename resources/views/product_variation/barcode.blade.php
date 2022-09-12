
<html>
<head>
    <style>
        p.inline {display: inline-block;}
        span { font-size: 13px;}
    </style>
    <style type="text/css" media="print">
        @page
        {
            size: auto;   /* auto is the initial value */
            margin: 0mm;  /* this affects the margin in the printer settings */

        }


    </style>
</head>
<body onload="window.print();">

    {!! $data !!}
    {{--    <p style="padding-left:10px; margin: 0;">ID:125463</p>--}}
    {{--    <img src="{{$data}}" alt="image">--}}

</body>
</html>
