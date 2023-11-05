<?php
session_start();
include("../config/dbcon.php");
include('../functions/myFunctions.php');

if (isset($_POST["add_category_btn"])) {

    $name = $_POST['name'];
    $slug = $_POST['slug'];
    $description = $_POST['description'];
    $meta_title = $_POST['meta_title'];
    $meta_description = $_POST['meta_description'];
    $meta_keywords = $_POST['meta_keywords'];
    $status = isset($_POST['status']) ? '1' : '0';
    $popular = isset($_POST['popular']) ? '1' : '0';

    $image = $_FILES['image']['name'];

    $path = "../uploads";

    $image_ext = pathinfo($image, PATHINFO_EXTENSION);
    $filename = time() . '.' . $image_ext;



    $cate_query = "INSERT INTO categories(name,slug,description,meta_title,meta_description,meta_keywords, status, popular,image) 
    VALUES('$name','$slug','$description','$meta_title','$meta_description','$meta_keywords','$status','$popular','$filename')";

    $cate_query_run = mysqli_query($con, $cate_query);

    if ($cate_query_run) {

        move_uploaded_file($_FILES['image']['tmp_name'], $path . '/' . $filename);
        redirect("add_category.php", "Category Added Successfully");


    } else {
        redirect("add_category.php", "Something Went Wrong");

    }

} else if (isset($_POST["update_category_btn"])) {

    $product_id = $_POST['product_id'];
    $name = $_POST['name'];
    $slug = $_POST['slug'];
    $description = $_POST['description'];
    $meta_title = $_POST['meta_title'];
    $meta_description = $_POST['meta_description'];
    $meta_keywords = $_POST['meta_keywords'];
    $status = isset($_POST['status']) ? '1' : '0';
    $popular = isset($_POST['popular']) ? '1' : '0';


    $new_image = $_FILES['image']['name'];
    $old_image = $_POST['old_image'];

    if ($new_image != "") {
        //change filename
        // $update_filename = $new_image;
        $image_ext = pathinfo($image, PATHINFO_EXTENSION);
        $update_filename = time() . '.' . $image_ext;
    } else {
        $update_filename = $old_image;
    }

    $path = "../uploads";

    $update_category_query = "UPDATE categories SET name='$name', slug='$slug', description='$description', 
    meta_title='$meta_title',meta_description='$meta_description',meta_keywords='$meta_keywords',
    status='$status',popular='$popular', image='$update_filename' WHERE id='$product_id'";


    $update_category_query_run = mysqli_query($con, $update_category_query);

    if ($update_category_query_run) {

        if ($_FILES['image']['name'] != "") {

            move_uploaded_file($_FILES['image']['tmp_name'], $path . '/' . $new_image);
            if (file_exists("../uploads/" . $old_image)) {
                unlink("../uploads/" . $old_image);
            }
        }
        redirect("edit_category.php?id=$product_id", "Category Updated Succesfully");

    } else {
        redirect("edit_category.php?id=$product_id", "Something Went Wrong");
    }

} else if (isset($_POST["delete_category_btn"])) {
    $product_id = mysqli_real_escape_string($con, $_POST["product_id"]);

    $product_query = "SELECT * FROM categories WHERE id='$product_id' ";
    $product_query_run = mysqli_query($con, $product_query);
    $category_data = mysqli_fetch_array($product_query_run);
    $image = $category_data["image"];


    $delete_query = "DELETE FROM categories WHERE id='$product_id'";
    $delete_query_run = mysqli_query($con, $delete_query);

    if ($delete_query_run) {
        if (file_exists("../uploads/" . $image)) {
            //deleted image exist
            unlink("../uploads/" . $image);
        }
        redirect("category.php", "Category Deleted Succesfully");

    } else {
        redirect("category.php", "Something Went Wrong");

    }

} else if (isset($_POST["add_product_btn"])) {

    $category_id = $_POST['category_id'];
    $name = $_POST['name'];
    $slug = $_POST['slug'];
    $small_description = $_POST['small_description'];
    $description = $_POST['description'];
    $original_price = $_POST['original_price'];
    $selling_price = $_POST['selling_price'];
    $qty = $_POST['qty'];
    $meta_title = $_POST['meta_title'];
    $meta_description = $_POST['meta_description'];
    $meta_keywords = $_POST['meta_keywords'];
    $status = isset($_POST['status']) ? '1' : '0';
    $trending = isset($_POST['trending']) ? '1' : '0';

    $image = $_FILES['image']['name'];

    $path = "../uploads";

    $image_ext = pathinfo($image, PATHINFO_EXTENSION);
    $filename = time() . '.' . $image_ext;


    if ($name != "" && $slug != "" && $description != "") {

        $product_query = "INSERT INTO products(category_id,name,slug,small_description,description,original_price, selling_price,qty,meta_title,meta_description,meta_keywords, status, trending,image) 
VALUES('$category_id','$name','$slug','$small_description','$description','$original_price','$selling_price','$qty','$meta_title','$meta_description','$meta_keywords','$status','$trending','$filename')";

        $product_query_run = mysqli_query($con, $product_query);

        if ($product_query_run) {

            move_uploaded_file($_FILES['image']['tmp_name'], $path . '/' . $filename);
            redirect("add_product.php", "Product Added Successfully");


        } else {
            redirect("add_product.php", "Something Went Wrong");

        }
    } else {
        redirect("add_product.php", "All fields are mandatory");

    }

} else if (isset($_POST["update_product_btn"])) {

    $product_id = $_POST["product_id"];
    $product_id = $_POST['product_id'];
    $name = $_POST['name'];
    $slug = $_POST['slug'];
    $small_description = $_POST['small_description'];
    $description = $_POST['description'];
    $original_price = $_POST['original_price'];
    $selling_price = $_POST['selling_price'];
    $qty = $_POST['qty'];
    $meta_title = $_POST['meta_title'];
    $meta_description = $_POST['meta_description'];
    $meta_keywords = $_POST['meta_keywords'];
    $status = isset($_POST['status']) ? '1' : '0';
    $trending = isset($_POST['trending']) ? '1' : '0';



    $path = "../uploads";

    $image = $_FILES['image']['name'];

    $image_ext = pathinfo($image, PATHINFO_EXTENSION);
    $filename = time() . '.' . $image_ext;

    $new_image = $_FILES['image']['name'];
    $old_image = $_POST['old_image'];

    if ($new_image != "") {
        //change filename
        // $update_filename = $new_image;
        $image_ext = pathinfo($new_image, PATHINFO_EXTENSION);
        $update_filename = time() . '.' . $image_ext;
    } else {
        $update_filename = $old_image;
    }

    $update_product_query = "UPDATE products SET name='$name',slug='$slug', small_description='$small_description', description='$description', original_price='$original_price', selling_price='$selling_price', qty='$qty', meta_title='$meta_title',meta_description='$meta_description', meta_keywords='$meta_keywords',status='$status',trending='$trending',image='$update_filename'
    WHERE id='$product_id' ";

    $update_product_query_run = mysqli_query($con, $update_product_query);


    if ($update_product_query_run) {

        if ($_FILES['image']['name'] != "") {

            move_uploaded_file($_FILES['image']['tmp_name'], $path . '/' . $update_filename);
            if (file_exists("../uploads/" . $old_image)) {
                unlink("../uploads/" . $old_image);
            }
        }
        redirect("edit_product.php?id=$product_id", "Product Updated Succesfully");

    } else {
        redirect("edit_product.php?id=$product_id", "Something Went Wrong");
    }






} else if (isset($_POST["delete_product_btn"])) {
    $product_id = mysqli_real_escape_string($con, $_POST["product_id"]);

    $product_query = "SELECT * FROM products WHERE id='$product_id' ";
    $product_query_run = mysqli_query($con, $product_query);
    $category_data = mysqli_fetch_array($product_query_run);
    $image = $category_data["image"];


    $delete_query = "DELETE FROM products WHERE id='$product_id'";
    $delete_query_run = mysqli_query($con, $delete_query);

    if ($delete_query_run) {
        if (file_exists("../uploads/" . $image)) {
            //deleted image exist
            unlink("../uploads/" . $image);
        }
        redirect("products.php", "Product Deleted Succesfully");

    } else {
        redirect("products.php", "Something Went Wrong");

    }

} 

else {
    header('Location: ../index.php');
}




?>