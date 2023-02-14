<!DOCTYPE html>
<html>
<head>
    <? include_once $_SERVER["DOCUMENT_ROOT"]."/includes/head.html"; ?>
</head>
<body>
<div class="container border my-5 p-1 col-6">
        <div class="d-flex">
            <div class="profile-pic col-1 my-auto"><img src="img_source/profile_pic.jpg" class="img-thumbnail rounded-circle img-responsive" alt="profile picture"></div>
            <div class="profile_name col-auto my-auto mx-1"><span class="h5">Ryan Noh</span></div>
        </div>
        <div class="container-fluid my-2 p-0">
            <div class="posting-main bg-image hover-zoom"><img src="img_source/main-img.jpg" alt="beach" class="img-fluid w-100"></div>
        </div>
        <div class="container-fluid px-0">
            <div class="posting-comments">
                <div class="comments-textarea align-items-bottom mb-3">
                    <textarea class="w-75 align-bottom"name="comment" id="comment" placeholder="Comment..."></textarea>
                    <button class="btn btn-primary" id="postBtn">Post</button>
                </div>
                <span class="h3">Comments</span> <br>
                <div class="table-responsive" id="action-taken-display-div">
                    <table class="display table table-md w-100" id="comments-table">
                        <thead>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function get_comments(){
            if (!$.fn.DataTable.isDataTable("#comments-table")) {
                $('#comments-table').DataTable({
                    ajax: {
                        url: './api/api.php',
                        type: 'POST',
                        data: function(d){
                            d.fn = 'get_comments';
                            d.returnJson = true;
                        },
                        dataSrc: function(d){
                            // console.log(d.bz_data)
                            return d.bz_data
                        }
                    },
                    columns: [
                            {
                                data: 'id',
                                className: 'd-none'
                            },
                            {
                                data: 'userId',
                                className: 'text-center align-middle col-3'
                            },
                            {
                                data: 'comments',
                                className: 'text-left align-middle col-9'
                            }
                        ],
                    columnDefs: [
                        {
                            targets: 0,
                            orderable: false,
                        },
                        {
                            targets: 1,
                            orderable: false
                        },
                        {
                            targets: 2,
                            orderable: false
                        }
                    ],
                    language: {
                        emptyTable: "No data to display."
                    },
                    searching: false,
                    order: [[0, 'desc'],[1, 'desc'],[2, 'desc']],
                    // ordering: false,
                })
            } else {
                $("#comments-table").DataTable().ajax.reload();
            }
        }

        function post_comment() {
            let comment = $('#comment').val()
            console.log(comment)
            $.ajax({
                url: './api/api.php',
                type: 'POST',
                data: {
                    'fn': 'post',
                    'params': '{"comment":"' + comment + '"}'
                },
                success: function(){
                    get_comments()
                }
            })
            $('#comment').val('')
        }


        $(document).ready(function() {
            get_comments()
        })

        $('#postBtn').on('click', function(){
            post_comment()
        })
    </script>
</body>
</html>