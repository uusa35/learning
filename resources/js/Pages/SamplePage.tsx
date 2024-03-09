import { Dialog, Menu, Popover, Transition } from "@headlessui/react";
import {
    ChevronDownIcon,
    MagnifyingGlassIcon,
    PhoneIcon,
    PlayCircleIcon,
} from "@heroicons/react/20/solid";
import {
    ArrowPathIcon,
    Bars3Icon,
    BellIcon,
    CalendarIcon,
    ChartPieIcon,
    CursorArrowRaysIcon,
    DocumentDuplicateIcon,
    FingerPrintIcon,
    FolderIcon,
    HomeIcon,
    SquaresPlusIcon,
    UsersIcon,
    XMarkIcon,
} from "@heroicons/react/24/outline";
import { Fragment, useState } from "react";

const navigation = [
    { name: "Dashboard", href: "#", icon: HomeIcon, current: true },
    { name: "Team", href: "#", icon: UsersIcon, current: false },
    { name: "Projects", href: "#", icon: FolderIcon, current: false },
    { name: "Calendar", href: "#", icon: CalendarIcon, current: false },
    {
        name: "Documents",
        href: "#",
        icon: DocumentDuplicateIcon,
        current: false,
    },
    { name: "Reports", href: "#", icon: ChartPieIcon, current: false },
];
const userNavigation = [
    { name: "Your profile", href: "#" },
    { name: "Sign out", href: "#" },
];

function classNames(...classes: any) {
    return classes.filter(Boolean).join(" ");
}

const solutions = [
    {
        name: "Analytics",
        description: "Get a better understanding of your traffic",
        href: "#",
        icon: ChartPieIcon,
    },
    {
        name: "Engagement",
        description: "Speak directly to your customers",
        href: "#",
        icon: CursorArrowRaysIcon,
    },
    {
        name: "Security",
        description: "Your customers' data will be safe and secure",
        href: "#",
        icon: FingerPrintIcon,
    },
    {
        name: "Integrations",
        description: "Connect with third-party tools",
        href: "#",
        icon: SquaresPlusIcon,
    },
    {
        name: "Automations",
        description: "Build strategic funnels that will convert",
        href: "#",
        icon: ArrowPathIcon,
    },
];
const callsToAction = [
    { name: "Watch demo", href: "#", icon: PlayCircleIcon },
    { name: "Contact sales", href: "#", icon: PhoneIcon },
];

export default function SamplePage() {
    const [sidebarOpen, setSidebarOpen] = useState<boolean>(false);

    return (
        <>
            <div>
                {/* mobile view side menu */}
                <Transition.Root show={sidebarOpen} as={Fragment}>
                    <Dialog
                        as="div"
                        className="relative z-50 lg:hidden"
                        onClose={setSidebarOpen}
                    >
                        <Transition.Child
                            as={Fragment}
                            enter="transition-opacity ease-linear duration-300"
                            enterFrom="opacity-0"
                            enterTo="opacity-100"
                            leave="transition-opacity ease-linear duration-300"
                            leaveFrom="opacity-100"
                            leaveTo="opacity-0"
                        >
                            <div className="fixed inset-0 bg-gray-900/80" />
                        </Transition.Child>

                        <div className="fixed inset-0 flex">
                            <Transition.Child
                                as={Fragment}
                                enter="transition ease-in-out duration-300 transform"
                                enterFrom="-translate-x-full"
                                enterTo="translate-x-0"
                                leave="transition ease-in-out duration-300 transform"
                                leaveFrom="translate-x-0"
                                leaveTo="-translate-x-full"
                            >
                                <Dialog.Panel className="relative mr-16 flex w-full max-w-xs flex-1">
                                    <Transition.Child
                                        as={Fragment}
                                        enter="ease-in-out duration-300"
                                        enterFrom="opacity-0"
                                        enterTo="opacity-100"
                                        leave="ease-in-out duration-300"
                                        leaveFrom="opacity-100"
                                        leaveTo="opacity-0"
                                    >
                                        <div className="absolute left-full top-0 flex w-16 justify-center pt-5">
                                            <button
                                                type="button"
                                                className="-m-2.5 p-2.5"
                                                onClick={() =>
                                                    setSidebarOpen(false)
                                                }
                                            >
                                                <span className="sr-only">
                                                    Close sidebar
                                                </span>
                                                <XMarkIcon
                                                    className="h-6 w-6 text-white"
                                                    aria-hidden="true"
                                                />
                                            </button>
                                        </div>
                                    </Transition.Child>

                                    <div className="flex grow flex-col gap-y-5 overflow-y-auto bg-gray-900 px-6 pb-2 ring-1 ring-white/10">
                                        <div className="flex h-16 shrink-0 items-center">
                                            <img
                                                className="h-8 w-auto"
                                                src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=500"
                                                alt="Your Company"
                                            />
                                        </div>
                                        <nav className="flex flex-1 flex-col">
                                            <ul
                                                role="list"
                                                className="-mx-2 flex-1 space-y-1"
                                            >
                                                {navigation.map((item) => (
                                                    <li key={item.name}>
                                                        <a
                                                            href={item.href}
                                                            className={classNames(
                                                                item.current
                                                                    ? "bg-gray-800 text-white"
                                                                    : "text-gray-400 hover:text-white hover:bg-gray-800",
                                                                "group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold",
                                                            )}
                                                        >
                                                            <item.icon
                                                                className="h-6 w-6 shrink-0"
                                                                aria-hidden="true"
                                                            />
                                                            {item.name}
                                                        </a>
                                                    </li>
                                                ))}
                                            </ul>
                                        </nav>
                                    </div>
                                </Dialog.Panel>
                            </Transition.Child>
                        </div>
                    </Dialog>
                </Transition.Root>

                {/*  sidebar for desktop */}
                <div className="hidden lg:fixed lg:inset-y-0 lg:left-0 lg:z-50 lg:block lg:w-20 lg:overflow-y-auto lg:bg-gray-900 lg:pb-4">
                    <div className="flex h-16 shrink-0 items-center justify-center">
                        <img
                            className="h-8 w-auto"
                            src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=500"
                            alt="Your Company"
                        />
                    </div>
                    <nav className="mt-8">
                        <ul
                            role="list"
                            className="flex flex-col items-center space-y-1"
                        >
                            {navigation.map((item) => (
                                <li key={item.name}>
                                    <a
                                        href={item.href}
                                        className={classNames(
                                            item.current
                                                ? "bg-gray-800 text-white"
                                                : "text-gray-400 hover:text-white hover:bg-gray-800",
                                            "group flex gap-x-3 rounded-md p-3 text-sm leading-6 font-semibold",
                                        )}
                                    >
                                        <item.icon
                                            className="h-6 w-6 shrink-0"
                                            aria-hidden="true"
                                        />
                                        <span className="sr-only">
                                            {item.name}
                                        </span>
                                    </a>
                                </li>
                            ))}
                        </ul>
                    </nav>
                </div>

                <div className="lg:pl-20">
                    <div className="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">
                        <button
                            type="button"
                            className="-m-2.5 p-2.5 text-gray-700 lg:hidden"
                            onClick={() => setSidebarOpen(true)}
                        >
                            <span className="sr-only">Open sidebar</span>
                            <Bars3Icon className="h-6 w-6" aria-hidden="true" />
                        </button>

                        {/* Separator */}
                        <div
                            className="h-6 w-px bg-gray-900/10 lg:hidden"
                            aria-hidden="true"
                        />

                        <div className="flex flex-1 w-full justify-between items-center gap-x-4 self-stretch lg:gap-x-6">
                            {/* right side */}
                            <div className="ms-[3%] flex flex-1 justify-between items-center w-full">
                                <div
                                    className={
                                        "hidden md:flex flex-1 flex-row gap-x-6 "
                                    }
                                >
                                    <button>item one</button>
                                    <Popover className="relative ">
                                        <Popover.Button className="hidden md:inline-flex items-center gap-x-1 text-sm font-semibold leading-6 text-gray-900">
                                            <span>Solutions</span>
                                            <ChevronDownIcon
                                                className="h-5 w-5"
                                                aria-hidden="true"
                                            />
                                        </Popover.Button>

                                        <Transition
                                            as={Fragment}
                                            enter="transition ease-out duration-200"
                                            enterFrom="opacity-0 translate-y-1"
                                            enterTo="opacity-100 translate-y-0"
                                            leave="transition ease-in duration-150"
                                            leaveFrom="opacity-100 translate-y-0"
                                            leaveTo="opacity-0 translate-y-1"
                                        >
                                            <Popover.Panel className="absolute left-1/2 z-10 mt-5 flex w-screen max-w-max -translate-x-1/2 px-4">
                                                <div className="w-screen max-w-md flex-auto overflow-hidden rounded-3xl bg-white text-sm leading-6 shadow-lg ring-1 ring-gray-900/5">
                                                    <div className="p-4">
                                                        {solutions.map(
                                                            (item) => (
                                                                <div
                                                                    key={
                                                                        item.name
                                                                    }
                                                                    className="group relative flex gap-x-6 rounded-lg p-4 hover:bg-gray-50"
                                                                >
                                                                    <div className="mt-1 flex h-11 w-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                                                        <item.icon
                                                                            className="h-6 w-6 text-gray-600 group-hover:text-indigo-600"
                                                                            aria-hidden="true"
                                                                        />
                                                                    </div>
                                                                    <div>
                                                                        <a
                                                                            href={
                                                                                item.href
                                                                            }
                                                                            className="font-semibold text-gray-900"
                                                                        >
                                                                            {
                                                                                item.name
                                                                            }
                                                                            <span className="absolute inset-0" />
                                                                        </a>
                                                                        <p className="mt-1 text-gray-600">
                                                                            {
                                                                                item.description
                                                                            }
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            ),
                                                        )}
                                                    </div>
                                                    <div className="grid grid-cols-2 divide-x divide-gray-900/5 bg-gray-50">
                                                        {callsToAction.map(
                                                            (item) => (
                                                                <a
                                                                    key={
                                                                        item.name
                                                                    }
                                                                    href={
                                                                        item.href
                                                                    }
                                                                    className="flex items-center justify-center gap-x-2.5 p-3 font-semibold text-gray-900 hover:bg-gray-100"
                                                                >
                                                                    <item.icon
                                                                        className="h-5 w-5 flex-none text-gray-400"
                                                                        aria-hidden="true"
                                                                    />
                                                                    {item.name}
                                                                </a>
                                                            ),
                                                        )}
                                                    </div>
                                                </div>
                                            </Popover.Panel>
                                        </Transition>
                                    </Popover>
                                    <button>item three</button>
                                </div>
                                <div className="flex w-full md:w-1/4 px-2 lg:ml-6 lg:justify-end">
                                    <div className="w-full">
                                        <label
                                            htmlFor="search"
                                            className="sr-only"
                                        >
                                            Search
                                        </label>
                                        <div className="relative">
                                            <div className="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                                <MagnifyingGlassIcon
                                                    className="h-5 w-5 text-gray-400"
                                                    aria-hidden="true"
                                                />
                                            </div>
                                            <input
                                                id="search"
                                                name="search"
                                                className="block w-full rounded-md border-0 bg-gray-700 py-1.5 pl-10 pr-3 text-gray-300 placeholder:text-gray-400 focus:bg-white focus:text-gray-900 focus:ring-0 sm:text-sm sm:leading-6"
                                                placeholder="Search"
                                                type="search"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {/* left side */}
                            <div className="flex  items-center gap-x-4 lg:gap-x-6">
                                <button
                                    type="button"
                                    className="-m-2.5 p-2.5 text-gray-400 hover:text-gray-500"
                                >
                                    <span className="sr-only">
                                        View notifications
                                    </span>
                                    <BellIcon
                                        className="h-6 w-6"
                                        aria-hidden="true"
                                    />
                                </button>

                                {/* Separator */}
                                <div
                                    className="hidden lg:block lg:h-6 lg:w-px lg:bg-gray-900/10"
                                    aria-hidden="true"
                                />

                                {/* Profile dropdown */}
                                <Menu as="div" className="relative">
                                    <Menu.Button className="-m-1.5 flex items-center p-1.5">
                                        <span className="sr-only">
                                            Open user menu
                                        </span>
                                        <img
                                            className="h-8 w-8 rounded-full bg-gray-50"
                                            src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                            alt=""
                                        />
                                        <span className="hidden lg:flex lg:items-center">
                                            <span
                                                className="ml-4 text-sm font-semibold leading-6 text-gray-900"
                                                aria-hidden="true"
                                            >
                                                Tom Cook
                                            </span>
                                            <ChevronDownIcon
                                                className="ml-2 h-5 w-5 text-gray-400"
                                                aria-hidden="true"
                                            />
                                        </span>
                                    </Menu.Button>
                                    <Transition
                                        as={Fragment}
                                        enter="transition ease-out duration-100"
                                        enterFrom="transform opacity-0 scale-95"
                                        enterTo="transform opacity-100 scale-100"
                                        leave="transition ease-in duration-75"
                                        leaveFrom="transform opacity-100 scale-100"
                                        leaveTo="transform opacity-0 scale-95"
                                    >
                                        <Menu.Items className="absolute right-0 z-10 mt-2.5 w-32 origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-gray-900/5 focus:outline-none">
                                            {userNavigation.map((item) => (
                                                <Menu.Item key={item.name}>
                                                    {({ active }) => (
                                                        <a
                                                            href={item.href}
                                                            className={classNames(
                                                                active
                                                                    ? "bg-gray-50"
                                                                    : "",
                                                                "block px-3 py-1 text-sm leading-6 text-gray-900",
                                                            )}
                                                        >
                                                            {item.name}
                                                        </a>
                                                    )}
                                                </Menu.Item>
                                            ))}
                                        </Menu.Items>
                                    </Transition>
                                </Menu>
                            </div>
                        </div>
                    </div>

                    <main className="xl:pl-96">
                        <div className="px-4 py-10 sm:px-6 lg:px-8 lg:py-6">
                            {/* Main area */}
                            <h1>testing</h1>
                        </div>
                    </main>
                </div>

                <aside className="fixed bottom-0 left-20 top-16 hidden w-96 overflow-y-auto border-r border-gray-200 px-4 py-6 sm:px-6 lg:px-8 xl:block">
                    <h1>another </h1>
                </aside>
            </div>
        </>
    );
}
