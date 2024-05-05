<!DOCTYPE html>
<html>
<head>
<link rel="icon" href="./images/favicon.png" type="image/png" sizes="16x16">
<title>Forum</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<!-- Custom CSS -->
<style>
  /* Body Styles */
  body {
    font-family: 'Arial', sans-serif; /* Custom font */
  }

  /* Header Styles */
  .header {
    background-image: linear-gradient(to bottom, rgba(174, 0, 0, 0.5), rgba(174, 0, 0, 0.9)), url('header-bg.jpg'); /* Gradient background */
    background-size: cover;
    color: white;
    padding: 100px 20px;
    text-align: center;
    margin-bottom: 20px;
    position: relative;
    overflow: hidden;
  }

  /* Header Content Styles */
  .header-content {
    position: relative;
    z-index: 1;
  }

  /* Parallax Effect Styles */
  .header::before {
    content: '';
    background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent overlay */
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 0;
    pointer-events: none;
    transform: translateZ(0);
    transition: opacity 0.5s;
  }

  .header:hover::before {
    opacity: 0.8; /* Adjust opacity on hover */
  }

  /* Form Styles */
  .form-container {
    background-color: #edfafa;
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1); /* Add shadow for depth */
  }

  /* Button Styles */
  .btn-primary {
    background-color: #AE0000;
    border-color: #AE0000;
    animation: pulse 1s infinite alternate; /* Button animation */
  }

  @keyframes pulse {
    0% {
      transform: scale(1);
    }
    100% {
      transform: scale(1.1);
    }
  }

  /* Table Styles */
  .table {
    background-color: white;
    border-radius: 10px;
    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1); /* Add shadow for depth */
  }

  /* Modal Styles */
  .modal-content {
    border-radius: 10px;
    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1); /* Add shadow for depth */
  }

  /* Rounded Images */
  .rounded-img {
    border-radius: 50%;
  }

  /* Hover Effects */
  .btn-primary:hover,
  .btn-primary:focus {
    background-color: #770000;
    border-color: #770000;
  }
</style>

</head>
<body>

<!-- Header -->
<div class="header">
  <div class="header-content">
    <h1>Community Forum</h1>
    <p>Welcome to our vibrant community! Ask questions, share knowledge, and connect with others.</p>
  </div>
</div>

<div class="container">

  <!-- New Question Form -->
  <div class="panel panel-default form-container">
    <div class="panel-body">
      <form name="frm" method="post">
        <input type="hidden" id="commentid" name="Pcommentid" value="0">
        <div class="form-group">
          <label for="usr">Your Name:</label>
          <input type="text" class="form-control" name="name" required>
        </div>
        <div class="form-group">
          <label for="comment">Your Question:</label>
          <textarea class="form-control" rows="5" name="msg" required></textarea>
        </div>
        <input type="button" id="butsave" name="save" class="btn btn-primary" value="Send">
      </form>
    </div>
  </div>
  
  <!-- Recent Questions -->
  <div class="panel panel-default">
    <div class="panel-body">
      <h4>Recent Questions</h4>           
      <table class="table" id="MyTable">
        <tbody id="record"></tbody>
      </table>
    </div>
  </div>

</div>

<!-- Reply Modal -->
<div id="ReplyModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content -->
    <div class="modal-content">
      <div class="modal-header" style="background-color: #AE0000; color: white; border-radius: 10px 10px 0 0;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Reply Question</h4>
      </div>
      <div class="modal-body">
        <form name="frm1" method="post">
          <input type="hidden" id="commentid" name="Rcommentid">
          <div class="form-group">
            <label for="usr">Your Name:</label>
            <input type="text" class="form-control" name="Rname" required>
          </div>
          <div class="form-group">
            <label for="comment">Your Reply:</label>
            <textarea class="form-control" rows="5" name="Rmsg" required></textarea>
          </div>
          <input type="button" id="btnreply" name="btnreply" class="btn btn-primary" value="Reply">
        </form>
      </div>
    </div>

  </div>
</div>

<!-- Include jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- Include Bootstrap JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<!-- Include your custom JavaScript -->
<script src="main.js"></script>

<script>
$(document).on("click", ".open-ReplyModal", function () {
     var commentid = $(this).data('id');
     $(".modal-body #commentid").val( commentid );
});
</script>

</body>
</html>
