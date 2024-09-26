@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="{{ asset('assets/css/depository.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/story.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

@endpush
@section('content')

 <div class="container-depository">
    @if(session('success-story'))
    <div class="message">
        <p class="text-success mt-2">{{ session('success-story') }}</p>
    </div>
@elseif(session('error-story'))
    <div class="message">
        <p class="text-danger mt-2">{{ session('error-story') }}</p>
    </div>
@endif
    <form action="{{ route('story.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="user-info">
        <div class="user-avatar">
            @if (Auth::user()->photo != null)
                <img src="{{ asset(Auth::user()->photo) }}" alt="user" class="img-avatar">
            @else
                <img src="{{ asset('assets/img/user.png') }}" alt="user" class="img-avatar">
            @endif
        </div>
        <input id="write" class="write" placeholder="Write your story here...">
        <div id="name" class="user-name d-none">{{ Auth::user()->name }}</div>
        <select id="story-comment" class="mx-2 custom-select d-none" name="allow_comments">
            <option value="1">Everyone can comment</option>
            <option value="0">No one can comment</option>
        </select>
        </div>
        <!-- HTML -->
        <div id="story-image" class="file-input-container d-none">
            <input type="file" id="image-input" name="photo" accept="image/*" max-size="2048">
            <label for="image-input">
                <i class="fas fa-file-image"></i>
                Select Image
            </label>
            <span id="file-size-alert" style="color: red; font-size: 12px;"></span>
            <div id="image-preview-container" style="display: none;">
                <img id="image-preview" src="" alt="Uploaded Image" style="max-width: 300px; max-height: 300px; margin-bottom: 5px;">
                <span id="delete-icon" class="icon-delete"></span> <!-- Add this icon element -->
            </div>
        </div>
        <textarea id="story-caption" name="caption" class="comment-box d-none" placeholder="Write your story here..."></textarea>
        <div id="story-button" class="comment-tools d-none">
        <button id="story-cancel" type="button" class="btn btn-secondary">Cancel</button>
        <button type="submit" class="btn btn-primary mx-2">Post</button>
        </div>
    </form>
    <div class="post mt-4">
        <form action="{{ route('story.search') }}" method="post">
            @csrf
            <div class="search-container">
                <input class="search" type="text" placeholder="Search for story" name="search">
                <button class="btn-primary btn-search">Search</button>
            </div>
        </form>
        @foreach ($stories as $story )
            @if ($story->id_user == Auth::user()->id)
            <div class="dropdown">
                <button class="dropbtn">&#8942;</button>
                <div class="dropdown-content">
                    <!-- Button to trigger modal -->
                    <a data-toggle="modal" data-target="#exampleModal-{{ $story->id }}">
                        &#9998; Edit
                    </a>
                    <a data-toggle="modal" data-target="#exampleModaldelete-{{ $story->id }}" class="text-danger">&#x1F5D1; Delete</a>
                </div>
            </div>
            @endif
            <!-- Modal -->
            <div class="modal fade" id="exampleModal-{{$story->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form  method="POST" action="{{ route('story.update', $story->id) }}">
                            @csrf
                            @method('PUT')
                        <div class="modal-body">
                            <select id="edit-comment" class="mx-2 custom-select" style="margin-bottom: 10px;" name="allow_comments">
                                @if ($story->allow_comments)
                                <option value="1">Everyone can comment</option>
                                <option value="0">No one can comment</option>
                                @else
                                <option value="0">No one can comment</option>
                                <option value="1">Everyone can comment</option>
                                @endif
                            </select>
                            <textarea class="form-control" style="margin-left: 8px;" id="textarea" rows="5" cols="30" name="caption" @if ($story->count_update > 4)
                                readonly
                            @endif>{{ $story->caption }}</textarea>
                            <p style="margin-left: 8px; margin-top: 5px; font-size: 0.8em; color: rgb(86, 86, 86);" class=" @if ($story->count_update > 4)
                                text-danger
                            @elseif ($story->count_update > 2)
                            text-warning
                            @endif "">Caption can be edited {{ 5 - $story->count_update }} more times</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
             <!-- Modal Delete -->
            <div class="modal fade" id="exampleModaldelete-{{$story->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form action="{{ route('story.destroy', $story->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmDeleteModalLabel">Are you sure you want to delete your story?</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
        
                            <div class="modal-body">
                                <p>Once this story is deleted, all its resources and data will be permanently deleted.</p>
                            </div>
        
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="post-info" @if ($story->id_user == Auth::user()->id) style="margin-top: -30px;" @endif>
                <div class="post-avatar">
                    @if ($story->user->photo != null)
                        <img src="{{ asset($story->user->photo) }}" alt="user" class="img-avatar-post">
                    @else
                        <img src="{{ asset('assets/img/user.png') }}" alt="user" class="img-avatar-post">
                    @endif
                </div>
                <div class="post-user">
                    <h5>{{ $story->user->name }}</h5>
                    <p><small>{{ $story->created_at->format('j M y, g:i') }}</small></p>
                </div>

            </div>
            <div class="post-content">
                <p>{{  $story->caption }}</p>
            </div>
            <div class="post-photo">
                @if ($story->photo != null)
                    <img src="{{ asset($story->photo) }}" alt="story" class="img-story-post">
                @endif
            </div>
            <div class="post-actions">
                <ul>
                    <li>a</li>
                    <li>a</li>
                </ul>
            </div>
            <hr>
        @endforeach
        <!-- Add pagination links -->
        {{ $stories->links() }}
        <!-- Handle the case where there are no stories -->
        @if ($stories->isEmpty())
            <p>No stories found.</p>
        @endif
    </div>
</div>
@endsection

@push('js')
<script>
const inputFile = document.getElementById('image-input');
const fileSizeAlert = document.getElementById('file-size-alert');

inputFile.addEventListener('change', (e) => {
  const fileSize = e.target.files[0].size;
  const maxSize = 2048 * 1024; // 2048 KB

  if (fileSize > maxSize) {
    fileSizeAlert.textContent = `File size exceeds maximum limit of 2048 KB`;
  } else {
    fileSizeAlert.textContent = '';
  }
});

const imageInput = document.getElementById('image-input');
const imagePreviewContainer = document.getElementById('image-preview-container');
const imagePreview = document.getElementById('image-preview');

imageInput.addEventListener('change', (e) => {
    const file = imageInput.files[0];
    const reader = new FileReader();
    reader.onload = (event) => {
        const imageDataUrl = event.target.result;
        imagePreview.src = imageDataUrl;
        imagePreviewContainer.style.display = 'block'; // show the container when image is uploaded
    };
    reader.readAsDataURL(file);
});

const deleteIcon = document.getElementById('delete-icon');

deleteIcon.addEventListener('click', () => {
  // Reset inputted image
  imagePreview.src = '';
  imagePreviewContainer.style.display = 'none'; // hide the container
  inputFile.value = ''; // reset the file input field
});

const textarea = document.querySelector('.comment-box');

textarea.addEventListener('input', (e) => {
  const inputValue = e.target.value;
  const allowedChars = /^[a-zA-Z0-9,._\-()\s]+$/;
  if (!allowedChars.test(inputValue)) {
    e.target.value = inputValue.replace(/[^a-zA-Z0-9,._\-()\s]/g, '');
  }
});

// Select all elements with aria-label "Pagination Navigation"
const paginationContainers = document.querySelectorAll('[aria-label="Pagination Navigation"]');

// Loop through each container and hide the SVG elements inside
paginationContainers.forEach(container => {
  const svgs = container.querySelectorAll('svg');
  svgs.forEach(svg => {
    svg.style.display = 'none';
  });
});


const url = window.location.href;
if (url.includes('/search')) {
  const paginationNav = document.querySelector('[aria-label="Pagination Navigation"]');
  paginationNav.style.display = 'none';
}

</script>
<script>
    const writeInput = document.getElementById('write');

    writeInput.addEventListener('focus', function() {
        this.classList.add('d-none');
        document.getElementById('story-button').classList.remove('d-none');
        document.getElementById('story-caption').classList.remove('d-none');
        document.getElementById('story-image').classList.remove('d-none');
        document.getElementById('story-comment').classList.remove('d-none');
        document.getElementById('name').classList.remove('d-none');
    });

    writeInput.addEventListener('click', function() {
        this.classList.add('d-none');
        document.getElementById('story-button').classList.remove('d-none');
        document.getElementById('story-caption').classList.remove('d-none');
        document.getElementById('story-image').classList.remove('d-none');
        document.getElementById('story-comment').classList.remove('d-none');
        document.getElementById('name').classList.remove('d-none');
    });

    const cancel = document.getElementById('story-cancel');

    cancel.addEventListener('click', function() {
        writeInput.classList.remove('d-none');
        document.getElementById('story-button').classList.add('d-none');
        document.getElementById('story-caption').classList.add('d-none');
        document.getElementById('story-image').classList.add('d-none');
        document.getElementById('story-comment').classList.add('d-none');
        document.getElementById('name').classList.add('d-none');
    });
</script>
@endpush
