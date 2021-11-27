@extends('layouts.app')

@section('content')

    <!-- users section -->
    <section class="main">

        <h3 class="text-blue">
            Groups List
        </h3>

        <div class="row mt-3">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-info">
                        <li class="breadcrumb-item"><a href="{{'/'}}">JuMatrimony</a></li>
                        <li class="breadcrumb-item"><a href="{{'/admin/index'}}">Admin Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Groups List</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div id="action_div">
            <button onclick="showNewGroupForm()" type="button" class="mb-1 btn btn-sm btn-primary">Add Group +</button>
        </div>
        <div class="form-group">
            <input type="text" id="search_box" name="search_box" class="form-control"
                   placeholder="Type your search query here...">
        </div>
        <div class="table-responsive" id="dynamic_content"></div>

    </section>
    <!-- users section ends -->

    <!-- New Group Modal -->
    <div class="modal fade" id="modal-new-group" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Group Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="new-group-slug" class="col-form-label">Slug:</label>
                            <input type="text" class="form-control" id="new-group-slug">
                        </div>
                        <div class="form-group">
                            <label for="new-group-name" class="col-form-label">Name:</label>
                            <input type="text" class="form-control" id="new-group-name">
                        </div>
                        <div class="form-group">
                            <label for="new-group-description" class="col-form-label">Description:</label>
                            <textarea class="form-control" id="new-group-description"></textarea>
                        </div>
                        {{--<div class="form-group form-row">
                            <div class="col">
                                <label for="new-group-price" class="col-form-label">Price:</label>
                                <input type="text" class="form-control" id="new-group-price">
                            </div>
                            <div class="col">
                                <label for="new-group-duration" class="col-form-label">Duration:</label>
                                <select class="form-control" id="new-group-duration">
                                    <option value="">Select</option>
                                    <option value="sem">Sem</option>
                                    <option value="year">Year</option>
                                </select>
                            </div>
                        </div>--}}


                        <div class="form-group form-row">
                            <div class="col">
                                <label for="new-group-likes" class="col-form-label">Likes:</label>
                                <input type="text" class="form-control" id="new-group-likes">
                            </div>
                            <div class="col">
                                <label for="new-group-status" class="col-form-label">Status:</label>
                                <select class="form-control" id="new-group-status">
                                    <option value="">Select</option>
                                    <option value=0 selected>Hidden (By Default)</option>
                                    <option value=1>Published</option>
                                </select>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="createNewGroup()">Create Group</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Group Modal -->
    <div class="modal fade" id="modal-group" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Group Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="group-slug" class="col-form-label">Slug:</label>
                            <input type="text" class="form-control" id="group-slug">
                        </div>
                        <div class="form-group">
                            <label for="group-name" class="col-form-label">Name:</label>
                            <input type="text" class="form-control" id="group-name">
                        </div>
                        <div class="form-group">
                            <label for="group-description" class="col-form-label">Description:</label>
                            <textarea class="form-control" id="group-description"></textarea>
                        </div>
                        <div class="form-group form-row">
                            <div class="col">
                                <label for="group-likes" class="col-form-label">Likes:</label>
                                <input type="text" class="form-control" id="group-likes">
                            </div>
                            <div class="col">
                                <label for="group-status" class="col-form-label">Status:</label>
                                <select class="form-control" id="group-status">
                                    <option value="">Select</option>
                                    <option value=0>Hidden (By Default)</option>
                                    <option value=1>Published</option>
                                </select>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="updateGroupInfo()">Update Group</button>
                    <input type="hidden" name="" id="group-id">

                </div>
            </div>
        </div>
    </div>



@endsection

@section('js')
    <script>
        $(document).ready(function (){

            load_data(1);

        });

        function load_data(page, query=''){
            $.ajax({
                url: "/Adjax/search-group",
                method: "POST",
                data:{
                    page:page,
                    query:query
                },
                success:function(data){
                    $('#dynamic_content').html(data);
                }
            });
        }

        $(document).on('click', '.page-link', function(){
            var page = $(this).data('page_number');
            var query = $('#search_box').val();
            load_data(page, query);
        });

        $('#search_box').keyup(function(){
            var query = $('#search_box').val();
            load_data(1, query);
        });

    </script>

    <script>
        function showNewGroupForm(){
            $('#modal-new-group').modal("show");
        }

        function createNewGroup(){

            var slug = $('#new-group-slug').val();
            var name = $('#new-group-name').val();
            var description = $('#new-group-description').val();
            var likes = $('#new-group-likes').val();
            var status = $('#new-group-status').val();

            $.post("/adjax/insertNewGroupRecord",{
                slug:slug,
                name:name,
                description:description,
                likes:likes,
                status:status

            },function (data, status) {
                console.log(data);
                $('#modal-new-group').modal("hide");
                load_data(1);
            });
        }

    </script>

    <script>
        function getGroupInfo(id){
            console.log(id);
            $('#group_id').val(id);
            $.post("/adjax/fetchSingleGroupRecord",{groupId:id},function (data, status) {

                console.log(data);
                var group = JSON.parse(data);
                $('#group-slug').val(group.slug);
                $('#group-name').val(group.title);
                $('#group-description').val(group.description);
                $('#group-likes').val(group.likes);
                $('#group-status').val(group.status);
                $('#group-id').val(group.id);

            });
            $('#modal-group').modal("show");
        }

        function updateGroupInfo(){

            var slug = $('#group-slug').val();
            var name = $('#group-name').val();
            var description = $('#group-description').val();
            var likes = $('#group-likes').val();
            var status = $('#group-status').val();
            var id = $('#group-id').val();
            $.post("/adjax/updateSingleGroupRecord",{
                slug:slug,
                name:name,
                description:description,
                likes:likes,
                status:status,
                id:id

            },function (data, status) {
                console.log(data);
                $('#modal-group').modal("hide");
                load_data(1);
            });
        }
    </script>

@endsection
