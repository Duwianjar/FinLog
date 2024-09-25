@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="{{ asset('assets/css/depository.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

@endpush
@section('content')
  <style>
    body {
      font-family: sans-serif;
    }

    .container {
      width: 500px;
      margin: 50px auto;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .user-info {
      display: flex;
      align-items: center;
    }

    .user-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      margin-right: 10px;
    }
    .img-avatar {
        width: 100%;
        height: auto;
        border-radius: 50%;
        margin: 0 auto;
        z-index: 1;
        position: relative;
    }

    .user-name {
      font-weight: bold;
    }

    .comment-box {
      margin-top: 20px;
      border: 1px solid #ccc;
      padding: 10px;
      border-radius: 5px;
      width: 100%;
    }

    .comment-tools {
      display: flex;
      justify-content: end;
      margin-top: 10px;
    }


    .custom-select {
        border: 1px solid #ccc;
        border-radius: 5px;
        width: 220px; /* adjust the width as needed */
        font-size: 16px;
        color: #333;
    }

    .btn-primary {
        color: white;
        padding: 5px 20px;
        border-radius: 5px;
    }

    .file-input-container {
    margin-top: 10px;
    margin-bottom: -20px;
    position: relative;
    display: inline-block;
    }

    .file-input-container input[type="file"] {
    display: none;
    }

    .file-input-container label {
    display: inline-block;
    padding: 10px 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    cursor: pointer;
    }

    .file-input-container label:hover {
        background-color: #f0f0f0;
    }

    .file-input-container i {
        margin-right: 10px;
    }
    .icon-delete {
        position: absolute;
        top: 10px;
        right: 10px;
        cursor: pointer;
    }

    .icon-delete:before {
        content: "\2715"; /* Unicode character for a cross icon */
        font-size: 18px;
        color: #red;
    }

    .message {
        display: block;
        opacity: 1;
        animation: hideMessage 1s forwards;
    }

    @keyframes hideMessage {
        0% {
            opacity: 1;
        }
        99.9% {
            opacity: 1;
        }
        100% {
            opacity: 0;
            display: none;
        }
    }

    .post {
  border: 1px solid #ccc;
  padding: 15px;
  margin-bottom: 15px;
}

.post-info {
  display: flex;
  align-items: center;
  margin-bottom: 10px;
}


.post-actions {
  margin-top: 10px;
  text-align: right;
}

.post-actions ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

.post-actions li {
  display: inline-block;
  margin-left: 10px;
}

.post-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      margin-right: 10px;
      margin-top: -20px;
    }
    .img-avatar-post {
        width: 100%;
        height: auto;
        border-radius: 50%;
        margin: 0 auto;
        z-index: 1;
        position: relative;
    }

    .post-user h5 {
        margin-bottom: -2px;
    }

    hr {
  border: none;
  height: 0.5px;
  background-color: #333;
  margin: 20px 0;
  box-shadow: 0 1px 0 rgba(97, 94, 94, 0.1);
}

.post-photo {
  text-align: start; /* center the image horizontally */
}

.post-photo img {
  max-width: 50%; /* make the image fit within the div */
  height: auto; /* maintain the image's aspect ratio */
  border-radius: 10px; /* add a slight border radius for a nicer look */
  margin: 10px; /* add some margin around the image */
}
  </style>

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
        <div class="user-name">{{ Auth::user()->name }}</div>
        <select class="mx-2 custom-select" name="allow_comments">
            <option value="1">Everyone can comment</option>
            <option value="0">No one can comment</option>
        </select>
        </div>
        <!-- HTML -->
        <div class="file-input-container">
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
        <textarea name="caption" class="comment-box" placeholder="Tulis ceritamu kamu disini..."></textarea>
        <div class="comment-tools">
        <button class="btn btn-secondary">Cancel</button>
        <button type="submit" class="btn btn-primary mx-2">Post</button>
        </div>
    </form>
    <div class="post mt-4">
        @foreach ($stories as $story )
            <div class="post-info">
                <div class="post-avatar">
                    @if ($story->user->photo != null)
                        <img src="{{ asset(Auth::user()->photo) }}" alt="user" class="img-avatar-post">
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
</script>
@endpush
