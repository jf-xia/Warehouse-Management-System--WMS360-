
<!DOOTYPE html>
<header>
    <title>Style Add</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</header>
<body>

<div class="container" style="margin-top: 2%;">
    <div class="row">
        <div class="col-6">
            <div style="border: 1px solid black;padding: 1rem;">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (Session::has('style_add_success_msg'))
                    <div class="alert alert-success">
                        {!! Session::get('style_add_success_msg') !!}
                    </div>
                @endif
                <form action="{{url('style')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="">Add Style</label>
                        <input type="text" name="style_name" class="form-control" id="style_name" value="{{ old('style_name') }}" placeholder="Enter style" required>
                    </div>
                    <button type="submit" class="btn btn-success">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
