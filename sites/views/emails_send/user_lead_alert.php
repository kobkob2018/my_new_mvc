<div style="direction:rtl;">
	<h2>שלום <?= $info['user']['info']['full_name']; ?>.<br/></h2>
	<h3>התקבלה בקשה להצעת מחיר מהאתר <?= $info['site']['domain'] ?></h3>
	<br/><br/>
	שם: <?= $info['lead']['full_name'] ?> <br/>
    קטגוריה: <?= $info['lead']['cat_tree_name'] ?> <br/>
	<a href="<?= outer_url('userLogin/resetPassword/'); ?>?row_id=<?= $this->data['forgot_password_token']['row_id'] ?>&token=<?= $this->data['forgot_password_token']['token'] ?>">לחץ כאן לאיפוס סיסמה</a> 

</div>
