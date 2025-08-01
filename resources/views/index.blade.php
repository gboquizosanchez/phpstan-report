@php
    $vite = Vite::useBuildDirectory('vendor/phpstan-report')
        ->withEntryPoints([
            'resources/js/app.js',
            'resources/css/app.css',
        ]);
@endphp

<!DOCTYPE html>
<html lang="en" x-data="phpstanPagination()">
    <head>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>PHPStan Analysis</title>
        <link rel="icon" type="image/svg+xml" href="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjNjM2NkYxIiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCI+PHBhdGggZD0iTTIwIDdMMTIgM0w0IDdWMTdMMTIgMjFMMjAgMTdWN1oiPjwvcGF0aD48cGF0aCBkPSJNMTIgMTJMMTIgMjEiPjwvcGF0aD48cGF0aCBkPSJNMTIgMTJMNCA3Ij48L3BhdGg+PHBhdGggZD0iTTEyIDEyTDIwIDciPjwvcGF0aD48L3N2Zz4=" />
        <script>
            (function() {
                const theme = localStorage.getItem('phpstan-theme') || 'system';
                if (theme === 'dark' || (theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            })();
        </script>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        {{ $vite }}
    </head>
    <body class="min-h-screen p-4 sm:p-6 lg:p-8 transition-colors duration-200 bg-gradient-to-b from-slate-50 to-white dark:from-slate-900 dark:to-slate-800">
        <!-- Header Section -->
        <div
            x-show="message"
            x-effect="if (message) { setTimeout(() => { message = ''; }, 3000) }"
            x-transition:enter="transform transition-all duration-300 ease-out"
            x-transition:enter-start="opacity-0 translate-y-6"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transform transition-all duration-200 ease-in"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-6"
            class="fixed top-2 right-4 z-50 w-80 md:w-96 shadow-md rounded-xl overflow-hidden"
            x-cloak
        >
            <div class="flex items-center gap-3 p-4 bg-white dark:bg-slate-800 border-l-4 border-green-500 dark:border-green-600">
                <div class="flex-shrink-0 p-1.5 rounded-full bg-green-100 dark:bg-green-900/50 text-green-600 dark:text-green-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div class="flex-1 mr-3">
                    <p class="text-sm font-medium text-slate-700 dark:text-slate-200" x-text="message"></p>
                </div>
                <button @click="message = ''" class="text-slate-400 hover:text-slate-500 dark:text-slate-500 dark:hover:text-slate-400 focus:outline-none">
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
        <header class="relative mb-8 bg-white dark:bg-slate-800 rounded-xl shadow-sm p-6 animate-fade-in">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-indigo-700 dark:from-blue-400 dark:to-indigo-500">
                        <button @click="loadPage(1)">
                            PHPStan Analysis
                        </button>
                    </h1>
                    <p class="mt-1 text-slate-500 dark:text-slate-400 text-sm">Code quality analysis results</p>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <!-- Theme Switcher -->
                    <div class="flex items-center gap-1 p-1 rounded-lg bg-slate-100 dark:bg-slate-700">
                        <!-- Light Theme Button -->
                        <button
                            @click="darkMode = 'light'"
                            :class="{ 'bg-white dark:bg-slate-600 shadow': darkMode === 'light', 'hover:bg-slate-200 dark:hover:bg-slate-600/50': darkMode !== 'light' }"
                            class="p-1.5 rounded-md text-slate-600 dark:text-slate-300 focus:outline-none"
                            aria-label="Set light theme"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </button>
                        <!-- Dark Theme Button -->
                        <button
                            @click="darkMode = 'dark'"
                            :class="{ 'bg-white dark:bg-slate-600 shadow': darkMode === 'dark', 'hover:bg-slate-200 dark:hover:bg-slate-600/50': darkMode !== 'dark' }"
                            class="p-1.5 rounded-md text-slate-600 dark:text-slate-300 focus:outline-none"
                            aria-label="Set dark theme"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                        </button>
                        <!-- System Theme Button -->
                        <button
                            @click="darkMode = 'system'"
                            :class="{ 'bg-white dark:bg-slate-600 shadow': darkMode === 'system', 'hover:bg-slate-200 dark:hover:bg-slate-600/50': darkMode !== 'system' }"
                            class="p-1.5 rounded-md text-slate-600 dark:text-slate-300 focus:outline-none"
                            aria-label="Set system theme"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </button>
                    </div>

                    <!-- Run Analysis Button -->
                    <button
                        @click="runPhpStan"
                        :disabled="running"
                        class="flex items-center justify-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-500 dark:to-indigo-500 text-white rounded-lg shadow-sm hover:shadow-md hover:from-blue-700 hover:to-indigo-700 dark:hover:from-blue-600 dark:hover:to-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-slate-800 disabled:opacity-60 transition-all duration-300 ease-out"
                    >
                        <span x-show="!running">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </span>
                        <span x-show="running">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </span>
                        <span x-text="running ? 'Analyzing...' : 'Run Analysis'"></span>
                    </button>
                </div>
            </div>
        </header>

        <!-- Dashboard Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Stats Card -->
            <div class="card lg:col-span-2 bg-white dark:bg-slate-800 rounded-xl shadow-sm p-6 animate-fade-in" style="animation-delay: 0.1s;">
                <h2 class="text-lg font-semibold text-slate-700 dark:text-slate-200 mb-4">Analysis Overview</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex items-center p-4 rounded-lg bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-700 dark:to-slate-800/80">
                        <div class="flex-shrink-0 p-3 rounded-full" :class="totals > 0 ? 'bg-rose-100 dark:bg-rose-900/30' : 'bg-emerald-100 dark:bg-emerald-900/30'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" :class="totals > 0 ? 'text-rose-500 dark:text-rose-400' : 'text-emerald-500 dark:text-emerald-400'" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="ml-5">
                            <h3 class="text-sm font-medium text-slate-500 dark:text-slate-400">Total Issues</h3>
                            <div class="mt-1 flex items-baseline gap-2">
                                <p class="text-2xl font-bold" :class="totals > 0 ? 'text-rose-600 dark:text-rose-400' : 'text-emerald-600 dark:text-emerald-400'" x-text="totals"></p>
                                <p class="text-sm text-slate-400 dark:text-slate-500">individual error(s)</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center p-4 rounded-lg bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-700 dark:to-slate-800/80">
                        <div class="flex-shrink-0 p-3 rounded-full" :class="filesCount > 0 ? 'bg-amber-100 dark:bg-amber-900/30' : 'bg-emerald-100 dark:bg-emerald-900/30'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" :class="filesCount > 0 ? 'text-amber-500 dark:text-amber-400' : 'text-emerald-500 dark:text-emerald-400'" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-5">
                            <h3 class="text-sm font-medium text-slate-500 dark:text-slate-400">Files with Issues</h3>
                            <div class="mt-1 flex items-baseline gap-2">
                                <p class="text-2xl font-bold" :class="filesCount > 0 ? 'text-amber-600 dark:text-amber-400' : 'text-emerald-600 dark:text-emerald-400'" x-text="filesCount"></p>
                                <p class="text-sm text-slate-400 dark:text-slate-500">affected file(s)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Level Control Card -->
            <div class="card bg-white dark:bg-slate-800 rounded-xl shadow-sm p-6 animate-fade-in" style="animation-delay: 0.2s;">
                <h2 class="text-lg font-semibold text-slate-700 dark:text-slate-200 mb-4">Analysis Level</h2>

                <div class="mb-6">
                    <div class="flex items-center justify-between mb-2">
                        <label for="level" class="text-sm font-medium text-slate-600 dark:text-slate-400">PHPStan Level (1-10):</label>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900/40 text-blue-800 dark:text-blue-300" x-text="'Current: ' + level"></span>
                    </div>

                    <div class="relative mt-1">
                        <input
                            id="level"
                            type="range"
                            min="1" max="10" step="1"
                            x-model.number="level"
                            class="w-full h-2 bg-slate-200 dark:bg-slate-700 rounded-lg appearance-none cursor-pointer"
                        />
                        <div class="flex justify-between text-xs text-slate-400 dark:text-slate-500 px-1 mt-1">
                            <span>Basic</span>
                            <span>Intermediate</span>
                            <span>Strict</span>
                        </div>
                    </div>
                </div>

                <button
                    @click="updateLevel"
                    :disabled="updatingLevel || level < 1 || level > 10"
                    class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-blue-600 dark:bg-blue-600 text-white rounded-lg shadow-sm hover:bg-blue-700 dark:hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-slate-800 disabled:opacity-60 transition-all duration-200"
                >
                    <span x-show="!updatingLevel">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </span>
                    <span x-show="updatingLevel">
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </span>
                    <span x-text="updatingLevel ? 'Setting level...' : 'Apply Level'"></span>
                </button>
            </div>
        </div>

        <!-- Results Section -->
        <div class="mb-10 animate-fade-in" style="animation-delay: 0.3s;">
            <h2 class="text-lg font-semibold text-slate-700 dark:text-slate-200 mb-4">Results</h2>

            <!-- Results List -->
            <div class="space-y-4" id="errors-list">
                <!-- With Errors -->
                <template x-if="files && files.length > 0">
                    <div class="space-y-4">
                        <template x-for="(fileData, fileIndex) in files" :key="fileData.file">
                            <div x-data="{ open: false }" class="card bg-white dark:bg-slate-800 rounded-xl shadow-sm overflow-hidden border border-slate-200 dark:border-slate-700">
                                <button
                                    @click="open = !open"
                                    class="file-header w-full text-left p-4 hover:bg-slate-50 dark:hover:bg-slate-700/80 focus:outline-none flex flex-wrap sm:flex-nowrap justify-between items-center"
                                >
                                    <div class="flex items-start space-x-3 overflow-hidden w-full sm:w-auto mb-2 sm:mb-0">
                                        <div class="flex-shrink-0 p-1 rounded-md bg-slate-100 dark:bg-slate-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-500 dark:text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 01 2-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </div>
                                        <div class="overflow-hidden min-w-0 flex-1">
                                            <h3 class="font-medium text-slate-700 dark:text-slate-200 truncate" x-text="fileData.file.replace(/\\/g, '/').split('/').pop() || fileData.file"></h3>
                                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 break-all" x-text="'Path: ' + fileData.file"></p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span class="whitespace-nowrap inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-rose-100 dark:bg-rose-900/30 text-rose-800 dark:text-rose-300" x-text="fileData.errors + ' issue' + (fileData.errors !== 1 ? 's' : '')"></span>
                                        <svg
                                            class="h-5 w-5 text-slate-400 dark:text-slate-500 transform transition-transform duration-200"
                                            :class="{'rotate-180': open}"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </button>

                                <div
                                    x-show="open"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 transform -translate-y-2"
                                    x-transition:enter-end="opacity-100 transform translate-y-0"
                                    x-transition:leave="transition ease-in duration-100"
                                    x-transition:leave-start="opacity-100 scale-100"
                                    x-transition:leave-end="opacity-0 scale-95"
                                    class="border-t border-slate-100 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/60"
                                >
                                    <template x-if="fileData.messages && fileData.messages.length > 0">
                                        <ul class="divide-y divide-slate-200 dark:divide-slate-700">
                                            <template x-for="(message, index) in fileData.messages" :key="index">
                                                <li class="error-item hover:bg-slate-100/80 dark:hover:bg-slate-700/50 border-l-rose-500" x-data="{ copied: false, tipCopied: false }">
                                                    <div class="p-4">
                                                        <div class="flex justify-between items-start mb-2">
                                                            <div class="flex items-center">
                                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-200 dark:bg-slate-700 text-slate-800 dark:text-slate-300" x-text="'Line ' + message.line"></span>
                                                                <div class="flex items-center ml-2 group relative">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-blue-600 dark:text-blue-600" viewBox="0 0 64 64" stroke="none" fill="currentColor">
                                                                        <path d="M52.47,13h-.76A3.71,3.71,0,0,0,48,16.71V17a8,8,0,0,1-8,8H24a8,8,0,0,1-8-8v-.3A3.71,3.71,0,0,0,12.29,13h-.76A7.53,7.53,0,0,0,4,20.53V49.47A7.53,7.53,0,0,0,11.53,57H52.47A7.53,7.53,0,0,0,60,49.47V20.53A7.53,7.53,0,0,0,52.47,13ZM25.42,46.58H14.64a2.2,2.2,0,0,1-2.13-2.85,8.27,8.27,0,0,1,5.12-5.3.55.55,0,0,0,.09-1A4.52,4.52,0,0,1,20,29a4.62,4.62,0,0,1,4.5,5,4.51,4.51,0,0,1-2.21,3.41.55.55,0,0,0,.09,1,8.26,8.26,0,0,1,5.16,5.31A2.21,2.21,0,0,1,25.42,46.58Zm16.58,0H34a2,2,0,0,1,0-4h8a2,2,0,0,1,0,4Zm8,0a2,2,0,1,1,2-2A2,2,0,0,1,50,46.58ZM50,37H34a2,2,0,0,1,0-4H50a2,2,0,0,1,0,4Z"/>
                                                                        <rect x="20" y="7" width="24" height="14" rx="5.54" ry="5.54"/>
                                                                    </svg>
                                                                </div>
                                                                <span class="text-xs font-medium text-slate-500 dark:text-slate-400 ml-2 transition-all duration-200 group-hover:text-indigo-500 dark:group-hover:text-indigo-400" x-text="message.identifier"></span>
                                                            </div>

                                                            <button
                                                                @click="
                                                                    navigator.clipboard.writeText(message.message);
                                                                    copied = true;
                                                                    setTimeout(() => copied = false, 1500);
                                                                "
                                                                class="flex items-center space-x-1 text-xs font-medium rounded-md px-2 py-1 transition-colors"
                                                                :class="copied ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300' : 'bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-600'"
                                                            >
                                                                <template x-if="!copied">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                                                        <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                                                                    </svg>
                                                                </template>
                                                                <template x-if="copied">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 24 24" stroke="none" fill="currentColor">
                                                                        <path d="M20.285 6.709a1 1 0 0 0-1.414-1.418L9 15.162 5.129 11.29a1 1 0 0 0-1.414 1.418l4.95 4.95a1 1 0 0 0 1.414 0l10.206-10.207z"/>
                                                                    </svg>
                                                                </template>
                                                                <span x-text="copied ? 'Copied' : 'Copy'"></span>
                                                            </button>
                                                        </div>

                                                        <pre style="white-space: pre-wrap; word-break: break-all; overflow-wrap: break-word;" class="p-3 rounded-md bg-slate-800 dark:bg-slate-900 text-slate-200 text-xs overflow-x-auto" x-text="message.message"></pre>


                                                        <!-- Tip section -->
                                                        <template x-if="message.tip">
                                                            <div class="mt-3">
                                                                <div class="flex items-center justify-between mb-1">
                                                                    <div class="flex items-center">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                                                        </svg>
                                                                        <span class="ml-2 text-xs font-semibold text-amber-600 dark:text-amber-400">Tip:</span>
                                                                    </div>
                                                                    <button
                                                                        @click="
                                                                            navigator.clipboard.writeText(message.tip);
                                                                            tipCopied = true;
                                                                            setTimeout(() => tipCopied = false, 1500);
                                                                        "
                                                                        class="flex items-center space-x-1 text-xs font-medium rounded-md px-2 py-1 transition-colors"
                                                                        :class="tipCopied ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300' : 'bg-amber-100/30 dark:bg-amber-900/30 text-amber-600 dark:text-amber-300 hover:bg-amber-200 dark:hover:bg-amber-800/30'"
                                                                    >
                                                                        <template x-if="!tipCopied">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                                <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                                                                <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                                                                            </svg>
                                                                        </template>
                                                                        <template x-if="tipCopied">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 24 24" stroke="none" fill="currentColor">
                                                                                <path d="M20.285 6.709a1 1 0 0 0-1.414-1.418L9 15.162 5.129 11.29a1 1 0 0 0-1.414 1.418l4.95 4.95a1 1 0 0 0 1.414 0l10.206-10.207z"/>
                                                                            </svg>
                                                                        </template>
                                                                        <span x-text="tipCopied ? 'Copied' : 'Copy'"></span>
                                                                    </button>
                                                                </div>
                                                                <pre style="white-space: pre-wrap; word-break: break-all; overflow-wrap: break-word;" class="p-3 bg-amber-50 dark:bg-amber-900/20 text-amber-800 dark:text-amber-300 text-xs rounded-md overflow-x-auto border border-amber-200 dark:border-amber-800/30" x-text="message.tip"></pre>
                                                            </div>
                                                        </template>
                                                    </div>
                                                </li>
                                            </template>
                                        </ul>
                                    </template>
                                </div>
                            </div>
                        </template>
                    </div>
                </template>

                <!-- No Errors -->
                <template x-if="!files || files.length === 0">
                    <div class="card bg-white dark:bg-slate-800 rounded-xl shadow-sm overflow-hidden border border-slate-200 dark:border-slate-700">
                        <div class="flex flex-col md:flex-row items-center p-8 animate-fade-in">
                            <div class="relative mb-4 md:mb-0 md:mr-6 flex-shrink-0">
                                <span class="absolute inset-0 rounded-full bg-green-200 dark:bg-green-900/40 animate-ping opacity-25"></span>
                                <div class="relative flex items-center justify-center w-16 h-16 bg-gradient-to-r from-green-400 to-emerald-500 dark:from-green-600 dark:to-emerald-600 rounded-full shadow-inner">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                            </div>
                            <div class="text-center md:text-left">
                                <h3 class="text-xl font-semibold mb-1 bg-gradient-to-r from-green-500 to-emerald-600 bg-clip-text text-transparent">All Clear!</h3>
                                <p class="text-slate-600 dark:text-slate-300">Your code has passed all PHPStan validations at the current level.</p>
                                <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">For more thorough validation, consider increasing the PHPStan level.</p>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Pagination -->
        <template x-if="files && files.length > 0 && totalPages > 1">
            <div class="mt-8">
                <div class="flex justify-center">
                    <!-- Desktop pagination -->
                    <nav class="hidden md:flex flex-wrap items-center gap-2" aria-label="Pagination">
                        <!-- Previous Button -->
                        <button
                            @click="loadPage(currentPage - 1)"
                            :disabled="currentPage <= 1"
                            class="p-2 rounded-md border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700 disabled:opacity-50 disabled:hover:bg-white dark:disabled:hover:bg-slate-800 transition-colors"
                            aria-label="Previous"
                        >
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>

                        <!-- Page Numbers (Static Implementation) -->
                        <div class="flex items-center gap-2">
                            <!-- First Page -->
                            <button
                                @click="loadPage(1)"
                                :class="{'bg-blue-600 border-blue-600 text-white dark:bg-blue-500 dark:border-blue-500': currentPage === 1,
                                        'bg-white border-slate-300 text-slate-600 dark:bg-slate-800 dark:border-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700': currentPage !== 1}"
                                class="inline-flex items-center justify-center w-10 h-10 border rounded-md transition-colors font-medium"
                            >1</button>

                            <!-- Ellipsis if needed -->
                            <template x-if="currentPage > 3">
                                <span class="inline-flex items-center justify-center px-1 text-slate-500 dark:text-slate-400">...</span>
                            </template>

                            <!-- Page before current if it exists -->
                            <template x-if="currentPage > 2">
                                <button
                                    @click="loadPage(currentPage - 1)"
                                    class="inline-flex items-center justify-center w-10 h-10 border rounded-md transition-colors font-medium bg-white border-slate-300 text-slate-600 dark:bg-slate-800 dark:border-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700"
                                    x-text="currentPage - 1"
                                ></button>
                            </template>

                            <!-- Current Page (if not first or last) -->
                            <template x-if="currentPage !== 1 && currentPage !== totalPages">
                                <button
                                    class="inline-flex items-center justify-center w-10 h-10 border rounded-md transition-colors font-medium bg-blue-600 border-blue-600 text-white dark:bg-blue-500 dark:border-blue-500"
                                    x-text="currentPage"
                                ></button>
                            </template>

                            <!-- Page after current if it exists -->
                            <template x-if="currentPage < totalPages - 1">
                                <button
                                    @click="loadPage(currentPage + 1)"
                                    class="inline-flex items-center justify-center w-10 h-10 border rounded-md transition-colors font-medium bg-white border-slate-300 text-slate-600 dark:bg-slate-800 dark:border-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700"
                                    x-text="currentPage + 1"
                                ></button>
                            </template>

                            <!-- Ellipsis if needed -->
                            <template x-if="currentPage < totalPages - 2">
                                <span class="inline-flex items-center justify-center px-1 text-slate-500 dark:text-slate-400">...</span>
                            </template>

                            <!-- Last Page (if not first) -->
                            <template x-if="totalPages > 1">
                                <button
                                    @click="loadPage(totalPages)"
                                    :class="{'bg-blue-600 border-blue-600 text-white dark:bg-blue-500 dark:border-blue-500': currentPage === totalPages,
                                            'bg-white border-slate-300 text-slate-600 dark:bg-slate-800 dark:border-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700': currentPage !== totalPages}"
                                    class="inline-flex items-center justify-center w-10 h-10 border rounded-md transition-colors font-medium"
                                    x-text="totalPages"
                                ></button>
                            </template>
                        </div>

                        <!-- Next Button -->
                        <button
                            @click="loadPage(currentPage + 1)"
                            :disabled="currentPage >= totalPages"
                            class="p-2 rounded-md border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700 disabled:opacity-50 disabled:hover:bg-white dark:disabled:hover:bg-slate-800 transition-colors"
                            aria-label="Next"
                        >
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </nav>

                    <!-- Mobile pagination -->
                    <nav class="flex md:hidden flex-wrap items-center gap-2" aria-label="Pagination">
                        <!-- Previous Button (Mobile) -->
                        <button
                            @click="loadPage(currentPage - 1)"
                            :disabled="currentPage <= 1"
                            class="p-2 rounded-md border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700 disabled:opacity-50 disabled:hover:bg-white dark:disabled:hover:bg-slate-800 transition-colors"
                            aria-label="Previous"
                        >
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>

                        <!-- Page indicator (Mobile) -->
                        <span class="px-4 py-2 text-sm font-medium text-slate-600 dark:text-slate-400">
                            <span x-text="currentPage"></span> / <span x-text="totalPages"></span>
                        </span>

                        <!-- Next Button (Mobile) -->
                        <button
                            @click="loadPage(currentPage + 1)"
                            :disabled="currentPage >= totalPages"
                            class="p-2 rounded-md border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700 disabled:opacity-50 disabled:hover:bg-white dark:disabled:hover:bg-slate-800 transition-colors"
                            aria-label="Next"
                        >
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </nav>
                </div>
            </div>
        </template>

        <!-- Items per page selector - Ahora fuera del template de paginación -->
        <template x-if="files && files.length > 0">
            <div class="mt-8 flex justify-center items-center gap-2">
                <label for="perPageSelector" class="text-sm text-slate-600 dark:text-slate-400">Items per page:</label>
                <select
                    id="perPageSelector"
                    x-model="perPage"
                    @change="changeItemsPerPage()"
                    class="rounded-md border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-400 text-sm py-1.5 px-3 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:focus:ring-blue-500 focus:border-blue-500 dark:focus:border-blue-500 transition-colors"
                >
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="75">75</option>
                    <option value="100">100</option>
                </select>
            </div>
        </template>

        <!-- Footer -->
        <footer class="text-center text-slate-400 dark:text-slate-500 text-xs py-6">
            <p>PHPStan Analysis Tool &copy; {{ date('Y') }}</p>
        </footer>

        <script>
            function phpstanPagination() {
                return {
                    files: @json($files),
                    filesCount: {{ $filesCount }},
                    totals: @json($errors['totals']['file_errors'] ?? 0),
                    currentPage: {{ $page }},
                    totalPages: Math.ceil({{ $total }} / {{ $perPage }}),
                    perPage: {{ $perPage }},
                    running: false,
                    updatingLevel: false,
                    level: {{ $level ?? 1 }},
                    message: '',
                    darkMode: localStorage.getItem('phpstan-theme') || 'system',

                    init() {
                        if (this.totalPages === 0) {
                            this.currentPage = 1;
                        }

                        this.applyTheme();

                        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
                            if (this.darkMode === 'system') {
                                this.applyTheme();
                            }
                        });

                        this.$watch('darkMode', value => {
                            localStorage.setItem('phpstan-theme', value);
                            this.applyTheme();
                        });
                    },

                    applyTheme() {
                        if (this.darkMode === 'light') {
                            document.documentElement.classList.remove('dark');
                        } else if (this.darkMode === 'dark') {
                            document.documentElement.classList.add('dark');
                        } else { // 'system'
                            if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                                document.documentElement.classList.add('dark');
                            } else {
                                document.documentElement.classList.remove('dark');
                            }
                        }
                    },

                    async loadPage(page) {
                        if (page < 1) return;
                        if (this.totalPages > 0 && page > this.totalPages) return;

                        this.currentPage = page;

                        const url = new URL(window.location.href);
                        url.searchParams.set('page', page);
                        url.searchParams.set('perPage', this.perPage);

                        const response = await fetch(url, {
                            headers: { 'Accept': 'application/json' }
                        });

                        if (! response.ok) {
                            console.error("Failed to load page data for page:", page);
                            return;
                        }

                        const data = await response.json();

                        this.files = data.files;
                        this.totals = data.totals;
                        this.filesCount = data.filesCount;
                        this.totalPages = Math.ceil(data.total / this.perPage);
                        if (this.totalPages === 0) {
                            this.currentPage = 1;
                        } else if (this.currentPage > this.totalPages) {
                            this.currentPage = this.totalPages;
                        }

                        history.replaceState(null, '', url);
                    },

                    async runPhpStan() {
                        this.running = true;

                        const response = await fetch('/phpstan-report/run', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content'),
                            }
                        });

                        this.running = false;

                        if (response.ok) {
                            await this.loadPage(1);

                            this.message = 'Analysis completed successfully';
                        }
                    },

                    async updateLevel() {
                        if (this.level < 1 || this.level > 10) return;

                        this.updatingLevel = true;
                        this.message = '';

                        try {
                            const fetchLvlResponse = await fetch('/phpstan-report/change-level', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                },
                                body: JSON.stringify({ level: this.level })
                            });

                            if (!fetchLvlResponse.ok) {
                                const error = await fetchLvlResponse.json();
                                this.message = error.error || 'Unknown error occurred while updating level';
                            } else {
                                await this.runPhpStan();
                                await this.loadPage(1);
                                this.message = 'Level updated successfully';
                            }
                        } catch (e) {
                            console.error('Error in updateLevel:', e);
                            this.message = 'An error occurred while updating the level';
                        } finally {
                            this.updatingLevel = false;
                        }
                    },

                    changeItemsPerPage() {
                        this.currentPage = 1;
                        this.loadPage(this.currentPage);
                    }
                }
            }
        </script>
    </body>
</html>
