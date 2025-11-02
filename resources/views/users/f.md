         <form action="{{ route('distroy.user', ['id' => $user->id]) }}" style="display: inline"
                                                            method="POST" class="delete-form">
                                                            @csrf
                                                            @method('DELETE')

                                                            <li>
                                                                <a href="javascript:void(0);"
                                                                    data-user-id="{{ $user->id }}"
                                                                    class="dropdown-item delete-button">
                                                                    <img src="assets/img/icons/delete1.svg" class="me-2"
                                                                        alt="img">Delete User
                                                                </a>
                                                            </li>
                                                            <!-- Delete User Modal -->
                                                            <div id="deleteModal{{ $user->id }}" class="modal">
                                                                <div class="modal-content">
                                                                    <span class="close">&times;</span>
                                                                    <h2>Confirm Deletion</h2>
                                                                    <p>Are you sure you want to {{ $user->username }} delete this item?</p>
                                                                    <!-- Pass user ID to data-user-id attribute -->
                                                                    <button class="confirmDelete noselect" data-user-id="{{ $user->id }}">
                                                                        <span class="text">Yes, Delete</span>
                                                                        <span class="icon">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                                                viewBox="0 0 24 24">
                                                                                <path
                                                                                    d="M24 20.188l-8.315-8.209 8.2-8.282-3.697-3.697-8.212 8.318-8.31-8.203-3.666 3.666 8.321 8.24-8.206 8.313 3.666 3.666 8.237-8.318 8.285 8.203z">
                                                                                </path>
                                                                            </svg>
                                                                        </span>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </form>