<form method="POST" action="#">
     <h3>Add a comment</h3>
     <textarea name="comment" placeholder="Comment here" rows="3" cols="30"></textarea>
     <input type="hidden" value="<?php echo $user->getId() ?>" name="userId">
     <input type="hidden" value="<?php echo $bark->getId() ?>" name="barkId">
     <input type="hidden" value="<?php echo date('H:i d.m.Y') ?>" name="creationDate"><br>
     <input type="submit" value="Save comment">
</form>


