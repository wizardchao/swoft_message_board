
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>新码萌自学留言板</title>
	<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/static/css/index.css">
</head>
<body>
	<div class="container">
 		<div class="bord">
			<div class="title"><span>留言板</span></div>
			<div class="main">
				<ul class="list-group">
                    <?php foreach($data['message_list'] as $el){ ?>
                        <a    <?php if($el['id']%10==0){ ?> class="list-group-item" <?php }  ?> class="<?php echo $el['class']; ?>" >
                             <?php echo $el['content']; ?>
                        </a>
                    <?php } ?>

				</ul>
			</div>
			<div class="page"><ul class="pagination"><li class="disabled"><span>&laquo;</span></li> <li class="active"><span>1</span></li><li><a href="/project/tpProject/message/public?page=2">2</a></li><li><a href="/project/tpProject/message/public?page=3">3</a></li><li><a href="/project/tpProject/message/public?page=4">4</a></li><li><a href="/project/tpProject/message/public?page=5">5</a></li><li><a href="/project/tpProject/message/public?page=6">6</a></li> <li><a href="/project/tpProject/message/public?page=2">&raquo;</a></li></ul></div>
			<div class="buttom">
				<form  id="msg" >
					<input class="input" name="msg"></input>
					<input class="inputs btn-lg btn-success" type="submit" value="提交">
				</form>
			</div>
 		</div>
	</div>


	<!-- 弹框模块 -->
    <div class="modal bs-example-modal-sm j-alert-modal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header"><h4 class="modal-title j-alert-title"></h4></div>
                <div class="modal-body"><p class="j-alert-content"></p></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default j-alert-btn-cancle" data-dismiss="modal"></button>
                    <button type="button" class="btn btn-success j-alert-btn-submit" data-dismiss="modal"></button>
                </div>
            </div>
        </div>
    </div>
	<script src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
	<script type="text/javascript" src="/static/js/index.js"></script>
    <script src="/static/js/custom.js"></script>  <!-- 弹框的js -->
    <script src="/static/js/global.js"></script>  <!-- 弹框的js -->
    <script src="http://cdn.bootcss.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
</body>

























































































































































</html>
