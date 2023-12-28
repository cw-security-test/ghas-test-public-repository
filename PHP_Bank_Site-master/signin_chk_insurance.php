<?php
	require 'library/database_func.php';

	function chk_insurance($ID)
	{
		$now=getQuery0('select UNIX_TIMESTAMP(now()) as now');
		$expire=getQuery1('select UNIX_TIMESTAMP((select Expired_Period from Current_Insurances where Proprietor_ID=?)) as expire','s',$ID);
		if($expire['expire'])
		{
			if((int)$now['now']>(int)$expire['expire'])
			{
				setQuery1("delete from Current_Insurances where Proprietor_ID=?", 's', $ID);
				setQuery1("update Members set Valid_Insurance='' where ID=?", 's', $ID);
				echo "<script>alert('Expired your insurance.');</script>";
			}
		}
	}
?>