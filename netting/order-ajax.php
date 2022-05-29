<?php
require_once 'crud.php';
$db = new Crud();









/* ---------SORTABLE--------- */
//admin
if (isset($_GET['adminMust'])) {

	$result = $db->orderUpdate("admin", $_POST['item'], "adminMust", "adminId");
	$returnMsg = ['processResult' => true, 'processMsg' => $result['status']];
	echo json_encode($returnMsg);
}

//setting
if (isset($_GET['setMust'])) {

	$result = $db->orderUpdate("setting", $_POST['item'], "setMust", "setId");
	$returnMsg = ['processResult' => true, 'processMsg' => $result['status']];
	echo json_encode($returnMsg);
}


if (isset($_POST['accId'])) {

	$sql = $db->qSql("SELECT * FROM sales INNER JOIN account ON sales.accId = account.accId INNER JOIN product ON sales.productId = product.productId WHERE sales.accId = '{$_POST['accId']}'");

	if ($sql->rowCount() > 0) { ?>

		<div id="productform" class="form-group">
			<label for="recipient-name" class="col-form-label">Ürün & Hizmet</label>
			<select class="form-control account" name="productId">
				<option value="">Ürün & Hizmet seçiniz...</option>
				<?php
				$sql = $db->read("product", [
					"columnsName" => "productId",
					"columnsSort" => "DESC"
				]);
				while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {   ?>
					<option value="<?= $row['productId'] ?>"><?= $row['productTitle'] ?></option>
				<?php } ?>
			</select>
		</div>


<?php } else {
		echo "FALSE";
	}
}
