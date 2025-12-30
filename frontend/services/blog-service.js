let BlogService = {
    init: function () {
        $("#blog-form").validate({
             rules: {
                title: 'required',
                content: {
                    required: true,
                    minlength: 5
                }
            },
            messages: {
                title: 'Please enter the title',
                content: {
                    required: 'Please enter the content',
                    minlength: 'Content must be at least 5 characters long'
                }
            },
            submitHandler: function (form) {
              let blog = Object.fromEntries(new FormData(form).entries());
              BlogService.addBlog(blog);
              form.reset();
            },
          });
       
        $("#editBlogForm").validate({
            submitHandler: function (form) {
              let blog = Object.fromEntries(new FormData(form).entries());
              BlogService.editBlog(blog);
            },
        });

        BlogService.getAllBlogs();
    },

    openAddModal : function() {
        $('#addBlogModal').show();
    }, 

    addBlog: function (blog) {
        $.blockUI({ message: '<h3>Processing...</h3>' });
        RestClient.post('blog', blog, function(response){
            toastr.success("Blog added successfully")
            $.unblockUI();
            BlogService.getAllBlogs();
            BlogService.closeModal();
        }, function(response){
            BlogService.closeModal()
            toastr.error(response.message);
        })
    },

    getAllBlogs : function(){
        RestClient.get("blogs", function(data){
            Utils.datatable('blogs-table', [
                { data: 'title', title: 'Title' },
                { data: 'content', title: 'Content' },
                {
                title: 'Actions',
                    render: function (data, type, row, meta) {
                        const rowStr = encodeURIComponent(JSON.stringify(row)); 

                        return `<div class="d-flex justify-content-center gap-2 mt-3">
                            <button class="btn btn-primary" onclick="BlogService.openEditModal('${row.id}')">Edit Blog</button>
                            <button class="btn btn-danger" onclick="BlogService.openConfirmationDialog(decodeURIComponent('${rowStr}'))">Delete Blog</button>
                            <button class="btn btn-secondary" onclick="BlogService.openViewMore('${row.id}')">View More</button>
                        </div>
                        `;
                    }
                }
            ], data, 10);
        }, function (xhr, status, error) {
            console.error('Error fetching data from file:', error);
        });
    },

    getBlogById : function(id) {
        RestClient.get('blog_by_id?id='+id, function (data) {
            localStorage.setItem('selected_blog', JSON.stringify(data))
            $('input[name="title"]').val(data.title)
            $('input[name="content"]').val(data.content)
            $.unblockUI();
        }, function (xhr, status, error) {
            console.error('Error fetching data');
            $.unblockUI();
        });
    }, 

    openViewMore : function(id) {
        window.location.replace("#view_more");
        BlogService.getBlogById(id) 
    },

    populateViewMore : function(){
        let selected_blog = JSON.parse(localStorage.getItem('selected_blog'))
        $("#blog-title").text(selected_blog.title)
        $("#blog-content").text(selected_blog.content)
    },

    openEditModal : function(id) {
        $.blockUI({ message: '<h3>Processing...</h3>' });
        $('#editBlogModal').show();
        BlogService.getBlogById(id)  
    }, 

    closeModal : function() {
        $('#editBlogModal').hide();
        $("#deleteBlogModal").modal("hide");
        $('#addBlogModal').hide();
    },

    editBlog : function(blog){
        console.log(blog)
        $.blockUI({ message: '<h3>Processing...</h3>' });
        RestClient.patch('blog/' + blog.id, blog, function (data) {
            $.unblockUI();
            toastr.success("Blog edited successfully")
            BlogService.closeModal()
            BlogService.getAllBlogs();
        }, function (xhr, status, error) {
            console.error('Error');
            $.unblockUI();
        });
    },

    openConfirmationDialog: function (blog) {
        blog = JSON.parse(blog)
        $("#deleteBlogModal").modal("show");
        $("#delete-blog-body").html(
        "Do you want to delete blog: " + blog.title + "?"
        );
        $("#delete_user_id").val(user.id);
    },

    deleteBlog: function () {
        RestClient.delete('blogs/' + $("#delete_blog_id").val(), null, function(response){
            BlogService.closeModal()
            toastr.success(response.message);
            BlogService.getAllBlogs();
        }, function(response){
            BlogService.closeModal()
            toastr.error(response.message);
        })
    }
}