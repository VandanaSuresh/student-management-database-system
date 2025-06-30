<?php while ($student = $result->fetch_assoc()) { ?>
    <tr>
        <td><?php echo $student['student_id']; ?></td>
        <td><?php echo $student['roll_number']; ?></td>
        <td><?php echo $student['first_name']; ?></td>
        <td><?php echo $student['last_name']; ?></td>
        <td><?php echo $student['department']; ?></td>
        <td><?php echo $student['year']; ?></td>
        <td><?php echo $student['email']; ?></td>
        <td>
            <!-- <a href="edit_student.php?id=<?php echo $student['student_id']; ?>" class="edit-btn">Edit</a> -->
            <a href="delete_student.php?id=<?php echo $student['student_id']; ?>" class="delete-btn">Delete</a>
        </td>
    </tr>
<?php } ?>