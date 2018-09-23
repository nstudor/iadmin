<?php if($r['role']==0) echo "???"; else { $rr=mysql_fetch_assoc(mysql_query("SELECT * FROM login_roles WHERE id=$r[role]")); echo $rr['rolename']; }?>
