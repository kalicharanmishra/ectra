@extends('admin.v1.templates.main')

@section('content')

<script src="{{ url('package/index.js') }}"></script>



<div class="app-content content">

    <div class="content-wrapper">

        <div class="content-wrapper-before"></div>

        <div class="content-header row">

        </div>

        <!-- Multi-column ordering table -->

        <div class="content-body">

            <section id="multi-column">

                <div class="row">

                <div class="col-lg-12 col-md-12">
                            <h4 class='breadcrumbs'>Course Classificate / List Course / Add Category</h4>
                 </div>

                    <div class="col-lg-12 col-md-12">

                        <div class="card">

                            <div class="card-header">

                                <h4 class="card-title">Add New Category</h4>

                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>

                                <div class="heading-elements">

                                    <ul class="list-inline mb-0">

                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>

                                    </ul>

                                </div>

                            </div>

                            <div class="card-content collapse show">

                                <div class="card-body card-dashboard">

                                    <form method="POST" action="{{ route('admin.v1.category.add-submit') }}" enctype="multipart/form-data">

                                        @csrf







                                        <div class="container">

                                    <?php $category = App\Models\Categories::with('childcat')->where('parent',null)->orWhere('parent',0)->select('id','name')->orderBy('id', 'desc')->get();?>


<style>
    .custom-control-label::before {
    pointer-events: none;
    border: 1px solid #adb5bd;
    background-color: #fff;
}

</style>
<script>
const catData = @json($category);
    if (typeof (ninotree) === 'undefined') {
    var ninotree = {
        test: {
            data:[
                        {
                            id: null,
                            name: 'Select a category',
                            selected: true,
                            childcat: catData
                        }]
                        ,
            getSignleValue: function () {
                var htmlNode = document.getElementById(ninotree.single.fields.id+'Form');
                var form = new FormData(htmlNode);
                var result = form.get(ninotree.single.fields.id);
                console.log(result);
                return result;
            }
        },
        single: {
            fields: {
                id: '',
                html: ''
            },
            methods: {
                makeForm: function (data) {
                    ninotree.single.fields.html += `<form id="${ninotree.single.fields.id}Form">`;
                    ninotree.single.fields.html += ninotree.single.methods.makeHTML(data);
                    ninotree.single.fields.html += '</form>';
                    return ninotree.single.fields.html;
                },
                makeHTML: function (data) {
                    if (data && data.length > 0) {
                        ninotree.single.fields.html += '<ul>';
                        data.forEach(node => {
                            var hasChild = node.childcat && node.childcat.length > 0;
                            if (hasChild) {
                                ninotree.single.fields.html += ninotree.single.methods.getParentNode(node);
                                ninotree.single.methods.makeHTML(node.childcat);
                                ninotree.single.fields.html += '</li>';
                            }
                            else {
                                ninotree.single.fields.html += ninotree.single.methods.getChildNode(node);
                            }
                        });
                        ninotree.single.fields.html += '</ul>';
                    }
                    return ninotree.single.fields.html;
                },
                registerCarets: function () {
                    var carets = document.getElementsByClassName('caret');
                    for (caret of carets) {
                        caret.addEventListener('click', function () {
                            this.parentElement.querySelector('ul').classList.toggle('collapsed');
                            this.classList.toggle('fa-caret-right');
                            this.classList.toggle('fa-caret-down');
                        });
                    }
                },
                getParentNode: function (node) {
                    if(node.selected){
                        return `<li><i class="fas fa-caret-down  caret"></i><input class="custom-control-input" type="radio" checked name="${ninotree.single.fields.id}" id="${node.id}" value="${node.id}"><label class="custom-control-label" for="${node.id}">${node.name}</label>`;
                    }
                    return `<li><i class="fas fa-caret-down  caret"></i><input class="custom-control-input" type="radio" name="${ninotree.single.fields.id}" id="${node.id}" value="${node.id}"><label class="custom-control-label" for="${node.id}">${node.name}</label>`;
                },
                getChildNode: function (node) {
                    if(node.selected){
                       return `<li><input class="custom-control-input" type="radio" checked name="${ninotree.single.fields.id}" id="${node.id}" value="${node.id}"><label class="custom-control-label" for="${node.id}">${node.name}</label></li>`;
                    }
                    return `<li><input class="custom-control-input" type="radio" name="${ninotree.single.fields.id}" id="${node.id}" value="${node.id}"><label class="custom-control-label" for="${node.id}">${node.name}</label></li>`;
                }
            },
            init: function (id, data) {
                ninotree.single.fields.id = id;
                var htmlNode = document.getElementById(id);
                if (!htmlNode) {
                    console.error('category does not exist');
                    return;
                }
                htmlNode.classList.add('ninotree');
                htmlNode.classList.add('custom-control');
                htmlNode.classList.add('custom-radio');
                htmlNode.innerHTML = ninotree.single.methods.makeForm(data);
                ninotree.single.methods.registerCarets();
            }
        },
        multiple: {}
    }
}

document.addEventListener("DOMContentLoaded", function () {
    ninotree.single.init('category', ninotree.test.data);
});
</script>
  <label for="category-name">Select Category</label>
 <div id='category'></div>

                                           

                                        </div>





                                        <div class="form-group">

                                            <label for="category-name">Category name</label>

                                            <input type="text" name="category-name" id="category-name" class="form-control" value="{{ old('category-name') }}">

                                            @if ($errors->has('category-name'))

                                            <div class="error text-danger">{{ $errors->first('category-name') }}

                                            </div>

                                            @endif

                                        </div>

                                        <div class="form-group">

                                            <label for="description">Description (max. 25o words)</label>

                                            <textarea name="description" id="description1" maxlength="250" class="form-control">{{ old('description') }}</textarea>

                                            @if ($errors->has('description'))

                                            <div class="error text-danger">{{ $errors->first('description') }}

                                            </div>

                                            @endif

                                        </div>

                                        <div class="form-group">

                                            <label for="banner">Category image</label>

                                            <input type="file" name="icon" id="icon" class="form-control" value="{{ old('icon') }}">

                                            @if ($errors->has('icon'))

                                            <div class="error text-danger">{{ $errors->first('icon') }}

                                            </div>

                                            @endif

                                        </div>



                                        

                                        <button type="submit" class="btn btn-primary">Submit</button>

                                    </form>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </section>

        </div>

    </div>

</div>









@endsection