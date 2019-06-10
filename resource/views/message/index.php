
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $data['title']; ?></title>
	<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/static/css/index.css">
</head>
<body>
	<div class="container">
 		<div class="bord">
			<div class="title"><span><?php echo $data['title']; ?></span></div>
			<div class="main">
				<ul class="list-group">
                    <?php foreach($data['message_list'] as $el){ ?>
                        <a    <?php if($el['id']%10==0){ ?> class="list-group-item" <?php }  ?> class="<?php echo $el['class']; ?>" >
                             <?php echo $el['tm_update'].' : '.$el['content']; ?>
                        </a>
                    <?php } ?>

				</ul>
			</div>
	    	<?php echo $page; ?>
			<div class="buttom">
				<form  id="msg" >
					<input class="input" name="msg" placeholder="请吐槽！😊"></input><br/>
					<input class="inputs btn-lg btn-success" style="margin-top:10px;" type="submit"  value="提交">
					<input class="inputs btn-lg btn-success"  type="button"   onclick="<?php echo 'location='."'".$data['url']."'"; ?>" value="登录">
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
