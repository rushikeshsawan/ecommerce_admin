   <!-- Add category modal -->

   <!-- Grids in modals -->


   <div class="modal fade" id="editproductmodal" tabindex="-1" aria-labelledby="addcategorymodal" aria-modal="true">
       <div class="modal-dialog">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title" id="addcategorymodal">Edit Product Modal</h5>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
                   <form method="post" action="/editProduct">
                       <div class="row g-3">

                           <div class="col-xxl-12">
                               <div>
                                   <label for="lastName" class="form-label">Product Name</label>
                                   <input name="productname" type="text" class="form-control" id="productname" placeholder="Enter Category Name" required>
                                   <input name="productid" type="hidden" class="form-control" id="productid" placeholder="Enter Category Name" required>
                               </div>
                           </div><!--end col-->
                           <div class="col-xxl-12">
                               <div>
                                   <label for="lastName" class="form-label">Product Image Link</label>
                                   <input type="url" name="productimg" class="form-control" id="productimg" placeholder="Enter Category Image Link" required>
                               </div>
                           </div><!--end col-->

                           <div class="col-xxl-12">
                               <div>
                                   <label for="emailInput" class="form-label">Product Description</label>
                                   <textarea name="productdesc" class="form-control" id="productdesc" required> </textarea>
                               </div>
                           </div><!--end col-->
                           <div class="col-xxl-12">
                               <div>
                                   <label for="emailInput" class="form-label">Product Price</label>
                                   <textarea name="productprice" type="number" class="form-control" id="productprice" required> </textarea>
                               </div>
                           </div><!--end col-->
                           <div class="col-xxl-12">
                               <div>
                                   <label for="emailInput" class="form-label">Product Category</label>

                                   <select name="productcatid" class="form-select" id="productcatid" required>
                                       <option value="">Choose...</option>
                                       <?php
                                        foreach ($categories as $category) {
                                        ?>
                                           <option value="<?= $category['id'] ?>"><?= $category['category_name']; ?></option>

                                       <?php


                                        }
                                        ?>

                                   </select>
                               </div>
                           </div><!--end col-->
                           <div class="col-xxl-12">
                               <div class="text-center"> <label for="passwordInput" class="form-label">Active/Inactive</label><br>

                                   <input class="form-check-input text-center" name="status" type="checkbox" role="switch" id="productstatus">
                               </div>
                           </div>





                           <div class="col-lg-12">
                               <div class="hstack gap-2 justify-content-end">
                                   <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                   <button type="submit" class="btn btn-primary">Submit</button>
                               </div>
                           </div><!--end col-->
                       </div><!--end row-->
                   </form>
               </div>
           </div>
       </div>
   </div>


   <!-- Add category modal end  -->