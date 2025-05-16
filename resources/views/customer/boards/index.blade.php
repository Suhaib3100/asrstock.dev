@extends('layouts.app')
@push('title')
    {{ $pageTitle }}
@endpush

@section('content')
    <!-- Main content -->
    <section class="admin-section">
        <div class="container">
            <div class="row rg-20">
                <div class="col-xl-3 col-lg-4 col-md-4">
                    @include('customer.layouts.sidebar')
                </div>
                <!--  -->
                <div class="col-xl-9 col-lg-8 col-md-8">
                    <div class="admin-section-right">
                        <div class="bd-one bd-c-stroke bd-ra-10 bg-white zaiStock-shadow-one p-sm-25 p-15">
                            <div class="pb-20 d-flex align-items-center justify-content-between">
                                <p class="fs-20 fw-500 lh-30 text-primary-dark-text">{{count($boards)}} {{__('Boards')}}</p>
                                <button type="button" class="zaiStock-btn"
                                        onclick="getEditModal('{{ route('frontend.board.modal') }}', '#createBoardsModal')">
                                    + {{__('Create Boards')}}</button>
                            </div>
                            <table class="table zTable zTable-last-item-border zTable-last-item-right" id="boardsTable">
                                <thead>
                                <tr>
                                    <td>
                                        <div class="text-nowrap">{{__('Board Name')}}</div>
                                    </td>
                                    <td>
                                        <div class="text-nowrap">{{__('Last Updated')}}</div>
                                    </td>
                                    <td>
                                        <div>{{__('Files')}}</div>
                                    </td>
                                    <td>
                                        <div>{{__('Action')}}</div>
                                    </td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($boards as $board)
                                    <tr>
                                        <td>{{$board->name}}</td>
                                        <td>{{formatDate($board->updated_at, 'd M Y')}}</td>
                                        <td>{{count($board->boardProducts)}}</td>
                                        <td>
                                            <div class="d-flex justify-content-end">
                                                <div class="dropdown dropdown-one">
                                                    <button
                                                        class="dropdown-toggle p-0 bg-transparent w-30 h-30 bd-one bd-c-stroke rounded-circle d-flex justify-content-center align-items-center"
                                                        type="button" data-bs-toggle="dropdown"
                                                        aria-expanded="false"><i
                                                            class="fa-solid fa-ellipsis"></i></button>
                                                    <div class="dropdown-menu">
                                                        <ul class="dropdownItem-one">
                                                            <li>
                                                                <a class="d-flex align-items-center cg-8" href="{{route('customer.boards.view', $board->id)}}">
                                                                    <div class="d-flex">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                             width="18" height="18" viewBox="0 0 18 18"
                                                                             fill="none">
                                                                            <path
                                                                                d="M16.158 8.28375C16.386 8.60348 16.5 8.76338 16.5 9C16.5 9.23663 16.386 9.39653 16.158 9.71625C15.1334 11.153 12.5169 14.25 9 14.25C5.48308 14.25 2.86657 11.153 1.84203 9.71625C1.61401 9.39653 1.5 9.23663 1.5 9C1.5 8.76338 1.61401 8.60348 1.84203 8.28375C2.86657 6.84708 5.48308 3.75 9 3.75C12.5169 3.75 15.1334 6.84708 16.158 8.28375Z"
                                                                                stroke="#686B8B"
                                                                                stroke-width="1.5"/>
                                                                            <path
                                                                                d="M11.25 9C11.25 7.75732 10.2427 6.75 9 6.75C7.75732 6.75 6.75 7.75732 6.75 9C6.75 10.2427 7.75732 11.25 9 11.25C10.2427 11.25 11.25 10.2427 11.25 9Z"
                                                                                stroke="#686B8B"
                                                                                stroke-width="1.5"/>
                                                                        </svg>
                                                                    </div>
                                                                    <p class="fs-14 fw-400 lh-24 text-para-text">{{__('View')}}</p>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <button onclick="getEditModal('{{ route('customer.boards.edit', $board->id) }}', '#editBoardsModal')" class="border-0  bg-white d-flex align-items-center cg-8">
                                                                    <div class="d-flex">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                             width="18" height="18" viewBox="0 0 18 18"
                                                                             fill="none">
                                                                            <path
                                                                                d="M10.5553 2.91409C11.1142 2.30856 11.3936 2.0058 11.6906 1.8292C12.407 1.40307 13.2893 1.38982 14.0178 1.79424C14.3197 1.96185 14.6077 2.25609 15.1838 2.84457C15.7598 3.43305 16.0479 3.72729 16.2119 4.0357C16.6079 4.77984 16.5949 5.68109 16.1777 6.41302C16.0049 6.71637 15.7085 7.00183 15.1157 7.57275L8.06295 14.3657C6.93966 15.4477 6.378 15.9886 5.67605 16.2628C4.97409 16.537 4.2024 16.5168 2.65902 16.4764L2.44904 16.471C1.97918 16.4587 1.74425 16.4525 1.60769 16.2975C1.47113 16.1425 1.48977 15.9032 1.52706 15.4246L1.54731 15.1648C1.65226 13.8176 1.70473 13.1441 1.96778 12.5386C2.23083 11.9332 2.68458 11.4416 3.59207 10.4584L10.5553 2.91409Z"
                                                                                stroke="#686B8B" stroke-width="1.5"
                                                                                stroke-linejoin="round"/>
                                                                            <path d="M9.75 3L15 8.25" stroke="#686B8B"
                                                                                  stroke-width="1.5"
                                                                                  stroke-linejoin="round"/>
                                                                            <path d="M10.5 16.5H16.5" stroke="#686B8B"
                                                                                  stroke-width="1.5"
                                                                                  stroke-linecap="round"
                                                                                  stroke-linejoin="round"/>
                                                                        </svg>
                                                                    </div>
                                                                    <p class="fs-14 fw-400 lh-24 text-para-text"> {{__('Edit')}}</p>
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button
                                                                    onclick="deleteItem('{{ route('customer.boards.delete', $board->id) }}')"
                                                                    class="align-items-center bg-white border-0 cg-8 d-flex deleteItem">
                                                                    <div class="d-flex">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                             width="18" height="18" viewBox="0 0 18 18"
                                                                             fill="none">
                                                                            <path
                                                                                d="M14.625 4.125L14.1602 11.6438C14.0414 13.5648 13.9821 14.5253 13.5006 15.2159C13.2625 15.5573 12.956 15.8455 12.6005 16.062C11.8816 16.5 10.9192 16.5 8.99452 16.5C7.06734 16.5 6.10372 16.5 5.38429 16.0612C5.0286 15.8443 4.722 15.5556 4.48401 15.2136C4.00266 14.5219 3.94459 13.5601 3.82846 11.6364L3.375 4.125"
                                                                                stroke="#FF2121" stroke-width="1.5"
                                                                                stroke-linecap="round"/>
                                                                            <path
                                                                                d="M2.25 4.125H15.75M12.0418 4.125L11.5298 3.0688C11.1897 2.3672 11.0196 2.01639 10.7263 1.79761C10.6612 1.74908 10.5923 1.70591 10.5203 1.66853C10.1954 1.5 9.80558 1.5 9.02588 1.5C8.2266 1.5 7.827 1.5 7.49676 1.67559C7.42357 1.71451 7.35373 1.75943 7.28797 1.80988C6.99123 2.03753 6.82547 2.40116 6.49396 3.12845L6.03969 4.125"
                                                                                stroke="#FF2121" stroke-width="1.5"
                                                                                stroke-linecap="round"/>
                                                                            <path d="M7.125 12.375V7.875"
                                                                                  stroke="#FF2121" stroke-width="1.5"
                                                                                  stroke-linecap="round"/>
                                                                            <path d="M10.875 12.375V7.875"
                                                                                  stroke="#FF2121" stroke-width="1.5"
                                                                                  stroke-linecap="round"/>
                                                                        </svg>
                                                                    </div>
                                                                    <p class="fs-14 fw-400 lh-24 text-para-text">{{__('Delete')}}</p>
                                                                </button>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Board Modal -->
    <div class="modal fade" id="createBoardsModal" tabindex="-1" aria-labelledby="createBoardsModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content border-0 bg-transparent">

            </div>
        </div>
    </div>
    <div class="modal fade" id="editBoardsModal" tabindex="-1" aria-labelledby="editBoardsModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content border-0 bg-transparent">

            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="{{ asset('assets/js/boards.js') }}"></script>
@endpush
