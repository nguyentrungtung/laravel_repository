@extends('admin.layouts.app')

@section('titel','Home Admin')
@section('css_global')
{!! \Html::style('adminlte/bower_components/select2/dist/css/select2.min.css') !!}
<style>
    .form-group {
        margin-left: 0px !important;
        margin-right: 0px !important;
    }
</style>
@endsection

@section('breadcrumb')
<section class="content-header">
    @include('admin.partials.breadcrumbs')
</section>
@endsection()

@section('content')
@php
$route = empty($post) ? 'post.store' : ['post.update', $post->id];
$method = empty($post) ? 'POST' : 'PUT';
@endphp
{!! Form::open(['route' => $route, 'method' => $method, 'class' => 'form-horizontal', 'post' => 'form'])
!!}
<section class="content">
    <div class="row">
        <div class="col-md-9">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Main</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="title">Title (<span class="text-danger" > required *</span>)</label>
                        <input type="text" name="title" value="{{ isset($post) ? $post->title : old('title') }}"
                            class="form-control" id="title" placeholder="Title">
                        @error('title')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    @if (isset($post))
                        <div class="form-group ">
                            <label for="seo_title">Url (<i>Url có định dạng $-$-$ và không chứa dấu</i>)</label>
                            <input type="text" name="slug" value="{{ isset($post) ? $post->slug : old('slug') }}"
                                class="form-control" id="slug" placeholder="slug">
                            @error('slug')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="author">Author (<span class="text-danger" > required *</span>)</label>
                        <input type="text" name="author" value="{{ isset($post) ? $post->author : old('author') }}"
                            class="form-control" id="author" placeholder="author">
                        @error('author')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="summary">Summary (<span class="text-danger" > required *</span>)</label>
                        <input type="text" name="summary" value="{{ isset($post) ? $post->summary : old('summary') }}"
                            class="form-control" id="summary" placeholder="summary">
                        @error('summary')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="status">Category (<span class="text-danger" > required *</span>)</label>
                        <select class="select2 form-control" style="width: 100%;" name="post_category_id">
                            @foreach ($postCategories as $data)
                            @if (isset($post))
                            <option class="text-black font-medium" value="{{ $data->id }}" {{$post->post_category_id ==
                                $data['id'] ? 'selected' : ''}}>
                                {{ $data['title'] }}
                            </option>
                            @else
                            <option class="text-black font-medium" value="{{ $data->id }}">
                                {{ $data['title'] }}
                            </option>
                            @endif
                            @endforeach
                        </select>
                        @error('post_category_id')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="status">Status</label>
                        <select class="select2 form-control" style="width: 100%;" name="status">
                            @foreach ($statusData as $data)
                            @if (isset($post))
                            <option class="text-black font-medium" value="{{ $data['value'] }}" {{$post->status ==
                                $data['value'] ? 'selected' : ''}}>
                                {{ $data['name'] }}
                            </option>
                            @else
                            <option class="text-black font-medium" value="{{ $data['value'] }}">
                                {{ $data['name'] }}
                            </option>
                            @endif
                            @endforeach
                        </select>
                        @error('status')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    @if (isset($post->meta_robot))
                        @php
                            $meta_robot = json_decode($post->meta_robot)
                        @endphp
                    @endif
                    <div class="form-group">
                        <label for="">Set index - follow :</label>
                        <br>
                        <label for="">
                            <span>Index -Follow</span>
                            <input type="checkbox" name="meta_robot[]"  value="Index,Follow"  @if(isset($meta_robot) && in_array('Index,Follow', $meta_robot)) checked @endif>
                        </label>
                        <label for="">
                            <span>NoIndex - NoFollow</span>
                            <input type="checkbox" name="meta_robot[]"  value="noIndex,nofollow"  @if(isset($meta_robot) && in_array('noIndex,nofollow', $meta_robot)) checked @endif>
                        </label>
                        <label for="">
                            <span>Index - NoFollow</span>
                            <input type="checkbox" name="meta_robot[]"  value="Index,nofollow"  @if(isset($meta_robot) && in_array('Index,nofollow', $meta_robot)) checked @endif>
                        </label>
                        <label for="">
                            <span>NoIndex -Follow</span>
                            <input type="checkbox" name="meta_robot[]"  value="noIndex,Follow"  @if(isset($meta_robot) && in_array('noIndex,Follow', $meta_robot)) checked @endif>
                        </label>
                        @error('meta_robot')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    @php
                    $labelData = ['hot', 'new'];
                    @endphp
                    <div class="form-group">
                        <label class="status">Label (<span class="text-danger" > required *</span>)</label>
                        <select class="select2 form-control" style="width: 100%;" name="label">
                            @foreach ($labelData as $data)
                            @if (isset($post))
                            <option class="text-black font-medium" value="{{ $data }}" {{$post->label ==
                                $data ? 'selected' : ''}}>
                                {{ $data }}
                            </option>
                            @else
                            <option class="text-black font-medium" value="{{ $data }}">
                                {{ $data }}
                            </option>
                            @endif
                            @endforeach
                        </select>
                        @error('label')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="summary">Description (<span class="text-danger" > required *</span>)</label>
                        <textarea name="description" id="ckeditor" rows="10" cols="80">
                            {!! isset($post->description) ? $post->description : old('description') !!}
                        </textarea>
                        @error('description')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Seo</h3>
                </div>
                <div class="box-body row">

                    <div class="form-group col-md-6">

                        <label for="seo_title">seo_title </label>
                        <input type="text" name="seo_title" value="{{ isset($post) ? $post->seo_title : old('seo_title') }}"
                            class="form-control" id="seo_title" placeholder="seo_title">
                        @error('seo_title')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror

                    </div>
                    <div class="form-group col-md-6">

                        <label for="seo_description">seo_description </label>
                        <input type="text" name="seo_description" value="{{ isset($post) ? $post->seo_description : old('seo_description') }}"
                            class="form-control" id="seo_description" placeholder="seo_description">
                        @error('seo_description')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror

                    </div>
                    <div class="form-group col-md-6">

                        <label for="seo_keyword">seo_keyword </label>
                        <input type="text" name="seo_keyword" value="{{ isset($post) ? $post->seo_keyword : old('seo_keyword') }}"
                            class="form-control" id="seo_keyword" placeholder="seo_keyword">
                        @error('seo_keyword')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror

                    </div>
                    {{-- <div class="form-group col-md-6">

                        <label for="seo_keyword">Time created </label>
                        <input type="datetime-local" name="time_created" value="{{ isset($post) ? $post->time_created : old('time_created') }}"
                            class="form-control" id="time_created" placeholder="time_created">
                        @error('time_created')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror

                    </div> --}}
                    <div class="form-group col-md-6">
                        <label for="seo_canonical">seo_canonical</label>
                        <input type="text" name="seo_canonical" value="{{ isset($post) ? $post->seo_canonical : old('seo_canonical') }}"
                            class="form-control" id="seo_canonical" placeholder="seo_canonical">
                        @error('seo_canonical')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror

                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div><!--End Row-->
        <div class="col-md-3">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Asset</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="thumbnail">Thumbnail (<span class="text-danger" > required *</span>)</label>
                        @if (isset($post) == true)
                        <img src="{{ asset($post->thumbnail) }}" style="width:100%" class="img-fluid" alt="" />
                        @else
                        <img src="{{ asset('theme/admin/empty_img.png') }}" style="width:100%" class="img-fluid"
                            alt=".." />
                        @endif
                        <button type="button" class="ckfinderUploadImage mt-2 btn btn-block bg-gradient-primary">
                            Upload
                        </button>
                        <input type="hidden" name="thumbnail"
                            value="{{ isset($post->thumbnail) ?$post->thumbnail : old('thumbnail') }}" />
                        @error('thumbnail')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header width-border">
                    <h3 class="box-title">Info admin</h3>
                </div>
                <div class="box-body">
                    @if (isset($post->info_admin))
                        <div class="form-group">
                            <label for="title">Info</label>
                            <div style="display:flex">
                                <input type="text" name="info_admin[0][name]" value="{{ isset($post->info_admin) ?  isset(json_decode($post->info_admin)[0]->name) ? json_decode($post->info_admin)[0]->name : '' : '' }}"
                                    class="form-control" id="title" placeholder="Name">
                                <input type="text" name="info_admin[0][phoneNumber]" value="{{ isset($post->info_admin) ?  isset(json_decode($post->info_admin)[0]->phoneNumber) ? json_decode($post->info_admin)[0]->phoneNumber : '' : '' }}"
                                    class="form-control" id="title" placeholder="PhoneNumber">

                            </div>
                            <div class="form-group">
                                <label for="title">Miêu tả</label>
                                <input type="text" name="info_admin[0][des]" value="{{ isset($post->info_admin) ?  isset(json_decode($post->info_admin)[0]->des) ? json_decode($post->info_admin)[0]->des : '' : '' }}"
                                        class="form-control" id="description" placeholder="description">
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="thumbnail">Avatar</label>
                                @if (isset($post->info_admin) == true)
                                <img src="{{ isset($post->info_admin) ?  asset(isset(json_decode($post->info_admin)[0]->avatar)) ? asset(json_decode($post->info_admin)[0]->avatar) : '' : '' }}" style="width:100%" class="img-fluid" alt="" />
                                @else
                                <img src="{{ asset('theme/admin/empty_img.png') }}" style="width:100%" class="img-fluid"
                                    alt=".." />
                                @endif
                                <button type="button" class="ckfinderUploadImage mt-2 btn btn-block bg-gradient-primary">
                                    Upload
                                </button>
                                <input type="hidden" name="info_admin[0][avatar]"
                                    value="{{ isset($post->info_admin) ?  isset(json_decode($post->info_admin)[0]->avatar) ? json_decode($post->info_admin)[0]->avatar : '' : '' }}" />
                                @error('avatar')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    @else

                    <div class="form-group">
                        <label for="title">Info</label>
                        <div style="display:flex">
                            <input type="text" name="info_admin[0][name]" value=""
                                class="form-control" id="Name" placeholder="Name">
                            <input type="text" name="info_admin[0][phoneNumber]" value=""
                                class="form-control" id="PhoneNumber" placeholder="PhoneNumber">

                        </div>
                        <div class="form-group">
                            <label for="title">Miêu tả</label>
                            <input type="text" name="info_admin[0][des]" value=""
                                    class="form-control" id="description" placeholder="description">
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label for="thumbnail">Avatar</label>
                            <img src="{{ asset('theme/admin/empty_img.png') }}" style="width:100%" class="img-fluid"
                                alt=".." />
                            <button type="button" class="ckfinderUploadImage mt-2 btn btn-block bg-gradient-primary">
                                Upload
                            </button>
                            <input type="hidden" name="info_admin[0][avatar]"
                                value="" />
                            @error('avatar')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    @endif

                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Schema ( <span style="color:red;">định dạng json</span> )</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <textarea type="json" name="schema" rows="8" cols="80"
                        class="form-control" id="seo_schema" placeholder="schema json">{{ isset($post) ? $post->schema : old('schema') }}</textarea>
                    </div>
                    @error('schema')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                </div>
            </div>
        </div>
        {!! Form::close() !!}
</section>
@endsection()

@section('script')
{!! \Html::script('adminlte/bower_components/select2/dist/js/select2.full.min.js') !!}
<script type="text/javascript">
    $('.btn-reset-form').on('click', '', function () {
        //$('.form-horizontal').trigger("reset");
        $('.form-horizontal').on('form-horizontal', function () {
            $(this).find('form')[0].reset();
        });
    });
</script>

<script>
    var editor = CKEDITOR.replace("ckeditor");
    CKFinder.setupCKEditor(editor);
    $(document).ready(function () {
        $('.select2').select2();
    });
    $(document).on('click', '.ckfinderUploadImage', function () {
        $currentElement = $(this);
        CKFinder.modal({
            language: "vi",
            chooseFiles: true,
            width: 800,
            height: 600,
            onInit: function (finder) {
                finder.on("files:choose", function (evt) {
                    var file = evt.data.files.first();
                    var thumbnail = file.getUrl();
                    $currentElement.prev().attr("src", `{{ asset( '${thumbnail}' ) }}`);
                    $currentElement.next().val(thumbnail);
                });
            },
        });
    })
    $(document).on('input', 'input[name=slug]', function() {
        var slug = $(this).val();
        slug = slug.toLowerCase().replace(/[^a-z0-9]+/g, '-').trim();
        $(this).val(slug);
    });
</script>
@endsection
