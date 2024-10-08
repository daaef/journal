@forelse ($journals as $journal)
    <div class="journal">

        <div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-[8px] p-4 md:p-5">
            <h3 class="font-semibold text-lg mb-2">{{ $journal->title }}</h3>
            <hr class="border-[#762A1E] mb-2">
            <div class="grid grid-cols-[1fr_2px_1fr]">
                <div class="py-3 space-y-3]">
                    <h5 class="flex w-full justify-between">
                        <span class="text-secondary-900 w-[45%]">Author(s):</span>
                        <span class="w-[50%]">{{ $journal->author }}</span>
                    </h5>
                    <h5 class="flex w-full justify-between">
                        <span class="text-secondary-900 w-[45%]">Publication Year:</span>
                        <span class="w-[50%]">2003</span>
                    </h5>
                    <h5 class="flex w-full justify-between">
                        <span class="text-secondary-900 w-[45%]">Publication Title:</span>
                        <span class="w-[50%]">{{ $journal->author }}</span>
                    </h5>
                    <h5 class="flex w-full justify-between">
                        <span class="text-secondary-900 w-[45%]">Resource Type:</span>
                        <span class="w-[50%]">{{ $journal->journal_format }}</span>
                    </h5>
                    <h5 class="flex w-full justify-between">
                        <span class="text-secondary-900 w-[45%]">Publisher:</span>
                        <span class="w-[50%]">Aminu Musa</span>
                    </h5>
                </div>
                <div class="w-[2px] h-full bg-secondary-900"></div>
                <div class="py-3 space-y-3] w-full pl-5">
                    <h5 class="flex w-full justify-between">
                        <span class="text-secondary-900 w-[45%]">Last Updated:</span>
                        <span class="w-[50%]">1st June, 2023</span>
                    </h5>
                    <h5 class="flex w-full justify-between">
                        <span class="text-secondary-900 w-[45%]">License:</span>
                        <span class="w-[50%]">CC BY-NC-ND</span>
                    </h5>
                    <h5 class="flex w-full justify-between">
                        <span class="text-secondary-900 w-[45%]">Available in:</span>
                        <span class="w-[50%]">{{ $journal->journal_language }}</span>
                    </h5>
                    <h5 class="flex w-full justify-between">
                        <span class="text-secondary-900 w-[45%]">Author(s) retains all rights</span>
                    </h5>
                </div>
            </div>
            <div class="flex justify-between mt-4">
                <div class="flex gap-x-3">
                    <a href=""
                        class="text-gray-100 bg-primary-500 rounded-[8px] px-4 py-1 font-bold hover:bg-primary-600">View</a>
                    <button class="text-gray-100 bg-primary-500 rounded-[8px] px-4 py-1 font-bold hover:bg-primary-600">
                        <svg width="15" height="15" viewBox="0 0 25 25" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M10.5469 0H14.4531C15.1025 0 15.625 0.522461 15.625 1.17188V9.375H19.9072C20.7764 9.375 21.2109 10.4248 20.5957 11.04L13.1689 18.4717C12.8027 18.8379 12.2021 18.8379 11.8359 18.4717L4.39941 11.04C3.78418 10.4248 4.21875 9.375 5.08789 9.375H9.375V1.17188C9.375 0.522461 9.89746 0 10.5469 0ZM25 18.3594V23.8281C25 24.4775 24.4775 25 23.8281 25H1.17188C0.522461 25 0 24.4775 0 23.8281V18.3594C0 17.71 0.522461 17.1875 1.17188 17.1875H8.33496L10.7275 19.5801C11.709 20.5615 13.291 20.5615 14.2725 19.5801L16.665 17.1875H23.8281C24.4775 17.1875 25 17.71 25 18.3594ZM18.9453 22.6562C18.9453 22.1191 18.5059 21.6797 17.9688 21.6797C17.4316 21.6797 16.9922 22.1191 16.9922 22.6562C16.9922 23.1934 17.4316 23.6328 17.9688 23.6328C18.5059 23.6328 18.9453 23.1934 18.9453 22.6562ZM22.0703 22.6562C22.0703 22.1191 21.6309 21.6797 21.0938 21.6797C20.5566 21.6797 20.1172 22.1191 20.1172 22.6562C20.1172 23.1934 20.5566 23.6328 21.0938 23.6328C21.6309 23.6328 22.0703 23.1934 22.0703 22.6562Z"
                                class="fill-gray-100" />
                        </svg>
                    </button>
                </div>
                <div class="flex gap-x-3">
                    <form action="{{ route('journals.dislike') }}" method="post">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ auth()->user() ? auth()->user()->id : null }}">
                        <input type="hidden" name="journal_id" value="{{ $journal->id }}" />
                        <button
                            class="text-gray-100 bg-primary-500 rounded-[8px] px-4 py-1 font-bold hover:bg-primary-600"
                            name="dislike" value="dislike">
                            <svg width="15" height="15" viewBox="0 0 25 25" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M15.3027 24.9476C16.5723 24.6574 17.3975 23.2457 17.1436 21.7949L17.0312 21.1588C16.7725 19.669 16.2939 18.2517 15.625 16.9628H22.6562C23.9502 16.9628 25 15.7631 25 14.2844C25 13.2522 24.4873 12.3538 23.7354 11.9074C24.2676 11.4164 24.6094 10.6631 24.6094 9.82055C24.6094 8.51486 23.7891 7.42679 22.71 7.19244C22.9248 6.78511 23.0469 6.31082 23.0469 5.80305C23.0469 4.61454 22.3682 3.60459 21.4307 3.25864C21.4648 3.0745 21.4844 2.87921 21.4844 2.67833C21.4844 1.19967 20.4346 0 19.1406 0H14.3799C13.4521 0 12.5488 0.312472 11.7773 0.898357L9.89746 2.33238C8.59375 3.3256 7.8125 4.99955 7.8125 6.79069V12.9955C7.8125 14.6248 8.46191 16.1593 9.57031 17.1804L9.93164 17.5096C11.2256 18.6925 12.1094 20.3553 12.4316 22.2078L12.5439 22.8439C12.7979 24.2947 14.0332 25.2377 15.3027 24.9476ZM1.5625 19.6411H4.6875C5.55176 19.6411 6.25 18.8432 6.25 17.8555V5.35666C6.25 4.36903 5.55176 3.57111 4.6875 3.57111H1.5625C0.698242 3.57111 0 4.36903 0 5.35666V17.8555C0 18.8432 0.698242 19.6411 1.5625 19.6411Z"
                                    class="fill-gray-100" />
                            </svg>
                        </button>
                    </form>
                    <form action="{{ route('journals.like') }}" method="post">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ auth()->user() ? auth()->user()->id : null }}">
                        <input type="hidden" name="journal_id" value="{{ $journal->id }}" />
                        <button
                            class="text-gray-100 bg-primary-500 rounded-[8px] px-4 py-1 font-bold hover:bg-primary-600"
                            name="like" value="like">
                            <svg width="15" height="15" viewBox="0 0 25 25" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M5.07812 10.9375H1.17187C0.524658 10.9375 0 11.4622 0 12.1094V23.8281C0 24.4753 0.524658 25 1.17187 25H5.07812C5.72534 25 6.25 24.4753 6.25 23.8281V12.1094C6.25 11.4622 5.72534 10.9375 5.07812 10.9375ZM3.125 23.0469C2.47778 23.0469 1.95312 22.5222 1.95312 21.875C1.95312 21.2278 2.47778 20.7031 3.125 20.7031C3.77222 20.7031 4.29687 21.2278 4.29687 21.875C4.29687 22.5222 3.77222 23.0469 3.125 23.0469ZM18.75 3.97715C18.75 6.04824 17.4819 7.20996 17.1251 8.59375H22.0921C23.7228 8.59375 24.9923 9.94854 24.9999 11.4306C25.0041 12.3064 24.6315 13.2494 24.0508 13.8328L24.0454 13.8381C24.5257 14.9776 24.4476 16.5743 23.5909 17.7185C24.0148 18.9829 23.5875 20.536 22.791 21.3687C23.0009 22.228 22.9006 22.9593 22.4908 23.548C21.4942 24.9798 19.0242 25 16.9355 25L16.7966 25C14.4388 24.9991 12.5092 24.1407 10.9587 23.4509C10.1795 23.1042 9.16079 22.6751 8.38784 22.6609C8.06851 22.6551 7.8125 22.3945 7.8125 22.0751V11.6371C7.8125 11.4809 7.8751 11.3309 7.98623 11.221C9.92051 9.30972 10.7522 7.28613 12.3376 5.69805C13.0605 4.97383 13.3234 3.87988 13.5775 2.82197C13.7947 1.9186 14.2489 0 15.2344 0C16.4062 0 18.75 0.390625 18.75 3.97715Z"
                                    class="fill-gray-100" />
                            </svg>
                        </button>
                    </form>
                    <form action="{{ route('journals.add-to-collection') }}" method="post">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ auth()->user() ? auth()->user()->id : null }}">
                        <input type="hidden" name="journal_id" value="{{ $journal->id }}" />
                        <button name="add_to_collection" value="add_to_collection"
                            class="text-gray-100 bg-primary-500 rounded-[8px] px-4 py-1 font-bold hover:bg-primary-600">Add
                            to Collection</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@empty
    <p>No published journals at the moment</p>
@endforelse

