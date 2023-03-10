   <!-- Add category modal -->

   <!-- Grids in modals -->


   <div class="modal fade" id="addcategorymodal" tabindex="-1" aria-labelledby="addcategorymodal" aria-modal="true">
       <div class="modal-dialog">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title" id="addcategorymodal">Add Category</h5>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
                   <form method="post" action="/addCategory">
                       <div class="row g-3">

                           <div class="col-xxl-12">
                               <div>
                                   <label for="lastName" class="form-label">Category Name</label>
                                   <input name="catname" type="text" class="form-control" id="lastName" placeholder="Enter Category Name" required>
                               </div>
                           </div><!--end col-->
                           <div class="col-xxl-12">
                               <div>
                                   <label for="lastName" class="form-label">Category Image Link</label>
                                   <input type="url" name="catimg" class="form-control" id="lastName" placeholder="Enter Category Image Link" required>
                               </div>
                           </div><!--end col-->

                           <div class="col-xxl-12">
                               <div>
                                   <label for="emailInput" class="form-label">Category Description</label>
                                   <textarea name="catdesc" class="form-control" placeholder="Enter Category Description" required> </textarea>
                               </div>
                           </div><!--end col-->
                           <div class="col-xxl-12">
                               <div class="text-center"> <label for="passwordInput" class="form-label">Active/Inactive</label><br>

                                   <input class="form-check-input text-center" name="status" type="checkbox" role="switch" id="editstatus">
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