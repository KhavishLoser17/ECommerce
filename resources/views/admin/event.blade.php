@extends('layouts.admin')
@section('content')
<div class="container mx-auto px-4 py-8 max-w-full w-full">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-3xl font-bold text-gray-800">Event Management</h1>
      <div class="flex space-x-2">

        <div class="relative">
          <input type="text" placeholder="Search events..." class="pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
          <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
        </div>
      </div>
    </div>

    <div class="bg-white rounded-xl shadow-md overflow-hidden">
      <div class="flex justify-between items-center p-4 border-b">
        <div class="flex space-x-4">
          <button class="px-4 py-2 rounded-lg bg-indigo-100 text-indigo-700 font-medium text-2xl">All Events</button>
          <button class="px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 text-2xl">Upcoming</button>
          <button class="px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 text-2xl">Past</button>
          <button class="px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 text-2xl">Drafts</button>
        </div>
        <div class="flex items-center space-x-2">
          <span class="text-gray-500">Filter by:</span>
          <select class="border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <option>All Categories</option>
            <option>Conference</option>
            <option>Workshop</option>
            <option>Webinar</option>
            <option>Social</option>
          </select>
        </div>
      </div>

      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th scope="col" class="px-6 py-3 text-left text-2xl font-medium text-gray-500 uppercase tracking-wider">
                Event
              </th>
              <th scope="col" class="px-6 py-3 text-left text-2xl font-medium text-gray-500 uppercase tracking-wider">
                Date & Time
              </th>
              <th scope="col" class="px-6 py-3 text-left text-2xl font-medium text-gray-500 uppercase tracking-wider">
                Location
              </th>
              <th scope="col" class="px-6 py-3 text-left text-2xl font-medium text-gray-500 uppercase tracking-wider">
                Attendees
              </th>
              <th scope="col" class="px-6 py-3 text-left text-2xl font-medium text-gray-500 uppercase tracking-wider">
                Status
              </th>
              <th scope="col" class="px-6 py-3 text-right text-2xl font-medium text-gray-500 uppercase tracking-wider">
                Actions
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <!-- Event 1 -->
            <tr class="hover:bg-gray-50">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="flex-shrink-0 h-10 w-10 rounded bg-indigo-100 flex items-center justify-center">
                    <i class="fas fa-users text-indigo-600"></i>
                  </div>
                  <div class="ml-4">
                    <div class="text-2xl font-medium text-gray-900">Annual Tech Conference</div>
                    <div class="text-2xl text-gray-500">Technology</div>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-2xl text-gray-900">Apr 15, 2025</div>
                <div class="text-2xl text-gray-500">09:00 AM - 05:00 PM</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-2xl text-gray-900">Convention Center</div>
                <div class="text-2xl text-gray-500">New York, NY</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex flex-col">
                  <div class="flex items-center mb-2">
                    <span class="bg-indigo-100 text-indigo-800 text-xs font-medium px-2 py-1 rounded-full">250 Students</span>
                  </div>
                  <div class="flex items-center">
                    <div class="flex -space-x-2 mr-2">
                      <img src="/api/placeholder/32/32" alt="Teacher" class="h-8 w-8 rounded-full border-2 border-white" />
                      <img src="/api/placeholder/32/32" alt="Teacher" class="h-8 w-8 rounded-full border-2 border-white" />
                      <img src="/api/placeholder/32/32" alt="Teacher" class="h-8 w-8 rounded-full border-2 border-white" />
                    </div>
                    <button class="text-xs bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-1 px-2 rounded-lg flex items-center transition-colors">
                      <span>View All</span>
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                      </svg>
                    </button>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 inline-flex text-2xl leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                  Published
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-2xl font-medium">
                <button class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</button>
                <button class="text-red-600 hover:text-red-900">Delete</button>
              </td>
            </tr>

            <!-- Event 2 -->
            <tr class="hover:bg-gray-50">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="flex-shrink-0 h-10 w-10 rounded bg-purple-100 flex items-center justify-center">
                    <i class="fas fa-book text-purple-600"></i>
                  </div>
                  <div class="ml-4">
                    <div class="text-2xl font-medium text-gray-900">UI/UX Workshop</div>
                    <div class="text-2xl text-gray-500">Design</div>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-2xl text-gray-900">Apr 22, 2025</div>
                <div class="text-2xl text-gray-500">10:00 AM - 03:00 PM</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-2xl text-gray-900">Design Studio</div>
                <div class="text-2xl text-gray-500">San Francisco, CA</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex -space-x-2">
                  <div class="h-8 w-8 rounded-full bg-gray-300 flex items-center justify-center text-2xl font-medium">40+</div>
                  <div class="h-8 w-8 rounded-full bg-red-500 flex items-center justify-center text-white text-2xl font-medium">AL</div>
                  <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center text-white text-2xl font-medium">RW</div>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 inline-flex text-2xl leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                  Draft
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-2xl font-medium">
                <button class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</button>
                <button class="text-red-600 hover:text-red-900">Delete</button>
              </td>
            </tr>

            <!-- Event 3 -->
            <tr class="hover:bg-gray-50">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="flex-shrink-0 h-10 w-10 rounded bg-blue-100 flex items-center justify-center">
                    <i class="fas fa-video text-blue-600"></i>
                  </div>
                  <div class="ml-4">
                    <div class="text-2xl font-medium text-gray-900">Product Launch Webinar</div>
                    <div class="text-2xl text-gray-500">Marketing</div>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-2xl text-gray-900">Apr 10, 2025</div>
                <div class="text-2xl text-gray-500">02:00 PM - 03:30 PM</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-2xl text-gray-900">Virtual Event</div>
                <div class="text-2xl text-gray-500">Online</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex -space-x-2">
                  <div class="h-8 w-8 rounded-full bg-gray-300 flex items-center justify-center text-2xl font-medium">120+</div>
                  <div class="h-8 w-8 rounded-full bg-pink-500 flex items-center justify-center text-white text-2xl font-medium">SL</div>
                  <div class="h-8 w-8 rounded-full bg-purple-500 flex items-center justify-center text-white text-2xl font-medium">DN</div>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 inline-flex text-2xl leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                  Cancelled
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-2xl font-medium">
                <button class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</button>
                <button class="text-red-600 hover:text-red-900">Delete</button>
              </td>
            </tr>

            <!-- Event 4 -->
            <tr class="hover:bg-gray-50">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="flex-shrink-0 h-10 w-10 rounded bg-green-100 flex items-center justify-center">
                    <i class="fas fa-glass-cheers text-green-600"></i>
                  </div>
                  <div class="ml-4">
                    <div class="text-2xl font-medium text-gray-900">Company Anniversary Party</div>
                    <div class="text-2xl text-gray-500">Social</div>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-2xl text-gray-900">May 05, 2025</div>
                <div class="text-2xl text-gray-500">07:00 PM - 11:00 PM</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-2xl text-gray-900">Grand Hotel</div>
                <div class="text-2xl text-gray-500">Chicago, IL</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex -space-x-2">
                  <div class="h-8 w-8 rounded-full bg-gray-300 flex items-center justify-center text-2xl font-medium">85+</div>
                  <div class="h-8 w-8 rounded-full bg-teal-500 flex items-center justify-center text-white text-2xl font-medium">MP</div>
                  <div class="h-8 w-8 rounded-full bg-orange-500 flex items-center justify-center text-white text-2xl font-medium">JD</div>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 inline-flex text-2xl leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                  Upcoming
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-2xl font-medium">
                <button class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</button>
                <button class="text-red-600 hover:text-red-900">Delete</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="px-4 py-3 border-t flex items-center justify-between">
        <div class="text-gray-500 text-2xl">
          Showing 4 of 24 events
        </div>
        <div class="flex space-x-1">
          <button class="px-3 py-1 border rounded-md hover:bg-gray-50 text-gray-500">
            <i class="fas fa-chevron-left"></i>
          </button>
          <button class="px-3 py-1 border rounded-md bg-indigo-600 text-white">1</button>
          <button class="px-3 py-1 border rounded-md hover:bg-gray-50 text-gray-500">2</button>
          <button class="px-3 py-1 border rounded-md hover:bg-gray-50 text-gray-500">3</button>
          <button class="px-3 py-1 border rounded-md hover:bg-gray-50 text-gray-500">...</button>
          <button class="px-3 py-1 border rounded-md hover:bg-gray-50 text-gray-500">6</button>
          <button class="px-3 py-1 border rounded-md hover:bg-gray-50 text-gray-500">
            <i class="fas fa-chevron-right"></i>
          </button>
        </div>
      </div>
    </div>
  </div>

@endsection
