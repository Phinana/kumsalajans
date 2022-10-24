<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    
</head>
<body>
<div class="row">
        <div class="col-md-10 col-md-offset-1">
            <table class="table table-bordered table-responsive table-striped">
                <thead>
                    <th>id</th>
                    <th>name</th>
                    <th>password</th>
                    <th>point</th>
                    <th>buttons</th>
                </thead>
                <td></td>
                <td><input class="TaskName" type="text" placeholder="name"></td>
                <td><input class="TaskPassword"type="text" placeholder="password"></td>
                <td><input class="TaskPoint" type="number" placeholder="point"></td>
                <td><button class="addTask">Add Task</button></td>
                <tbody id="todosTable">
                </tbody>
                
            </table>
        </div>
    </div>
    
    <div class= "text-center">
        <input type="text" placeholder="searchkey needed" class="search_box">
        <button type="button" class="btn btn-secondary search_button">Search</button>
    </div>
</body>
</html>

<!-- Edit Popup -->
<div class="modal fade" id="addnew" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">Add New Task</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <div class="modal-body">
                <div class="mb-3">
                    <label for="name">name</label>
                    <input type="text" name="name" class="form-control editName" placeholder="Input name" required>
                </div>
                <div class="mb-3">
                    <label for="password">password</label>
                    <input type="text" name="password" class="form-control editPassword" placeholder="Input password" required>
                </div>
                <div class="mb-3">
                    <label for="point">point</label>
                    <input type="number" name="point" class="form-control editPoint" placeholder="Input point" required>
                </div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary modal_edit_button">Save</button>
      </div>
    </div>
  </div>
</div>
<!-- Edit Popup End -->

<!-- Delete Popup -->
<div class="modal fade" id="deletemodal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">Delete Task</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <h4 class="text-center">You sure?</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" id="deletemember" class="btn btn-danger" class="modal_delete_button">Delete</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Delete Popup End -->

<script type="text/javascript">
    var currentId = 0;

        $(document).ready(function(){
            //when documents ready we get tasks.
            showTasks();
        });
   
        //gets all the tasks from database and refreshes the table. I made it function because i call it so many times
        function showTasks(){
            $.ajax({
                type: "POST",
                data:{
                    '_token': '{{ csrf_token() }}',
                },
                url: "{{ route('show.getTasks') }}",
                success: function (response) {

                    $('#todosTable').empty().html(response);
                }
            });
        }

        //It adds tasks.
        $(document).on("click", ".addTask", function () {
            var taskName = $(".TaskName").val()
            var taskPassword = $(".TaskPassword").val()
            var taskPoint = $(".TaskPoint").val()
            
            $.ajax({
                type: "POST",
                data:{
                    'taskName': taskName,
                    'taskPassword': taskPassword,
                    'taskPoint': taskPoint,
                    '_token': '{{ csrf_token() }}',
                },
                url: "{{ route('show.addTask') }}",
                success: function (response) {

                }
            });
            showTasks();
        });

        //this for edit button to get the id of the object, id is stored in public not in a function because it comes from another page named getTasks.php
        $(document).on("click", ".delete_button", function () {
            currentId = $(this).attr("value");
        });

        //delete button on popup does the actual job
        $(document).on("click", "#deletemember", function () {
            $.ajax({
                type: "POST",
                data:{
                    'taskId': currentId,
                    '_token': '{{ csrf_token() }}',
                },
                url: "{{ route('show.deleteTask') }}",
                success: function (response) {

                }
            });
            $("#deletemodal").modal("hide");
            showTasks();
        });

        //this for edit button to get the id of the object, id is stored in public not in a function because it comes from another page named getTasks.php
        $(document).on("click", ".edit_button", function () {
            currentId = $(this).attr("value");
        });

        //this sfunction also called when edit button on edit popup is clicked.
        $(document).on("click", ".modal_edit_button", function () {
            var name = $(".editName").val();
            var password = $(".editPassword").val();
            var point = $(".editPoint").val();
            $.ajax({
                type: "POST",
                data:{
                    'currentId': currentId,
                    'name': name,
                    'password': password,
                    'point': point,
                    '_token': '{{ csrf_token() }}',
                },
                url: "{{ route('show.editTask') }}",
                success: function (response) {
                    
                }
            });
            showTasks();
        });

        //When search button is clicked, it calls the function in controller and gets the filtered data, getTasks.php converts data into rows and returns it
        $(document).on("click", ".search_button", function () {
            var searchWord = $(".search_box").val();
            $.ajax({
                type: "POST",
                data:{
                    'searchWord': searchWord,
                    '_token': '{{ csrf_token() }}',
                },
                url: "{{ route('show.searchTask') }}",
                success: function (response) {

                    //we empty table body before then we write the response we before got from getTasks php
                    $('#todosTable').empty().html(response);
                }
            });
        });
          
</script>