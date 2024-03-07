import CreateNewElement from "@/components/CreateNewElement";
import Dropdown from "@/components/Dropdown";
import MainTable from "@/components/MainTable";
import Pagination from "@/components/Pagination";
import { getCurrentModule, getTrans } from "@/constants";
import AuthenticatedLayout from "@/layouts/AuthenticatedLayout";
import { PageProps } from "@/types/index.d";
import { User } from "@/types/queries";
import { ArrowDownCircleIcon } from "@heroicons/react/24/outline";
import { Head, router, usePage } from "@inertiajs/react";
import { isEmpty, map } from "lodash";
import pluralize from "pluralize";

export default function ({
    elements,
    currentRouteName,
}: PageProps): React.ReactNode {
    const {
        props: {
            auth,
            ziggy: { query },
        },
    }: any = usePage();

    const handleDelete = (id: number) => {
        router.delete(route("user.destroy", { id }), {
            headers: {
                Authorization: `Bearer ${auth.api_token}`,
            },
        });
    };

    return (
        <AuthenticatedLayout header={currentRouteName}>
            <Head title={getTrans(currentRouteName)} />
            <div className="py-12 ">
                <div className="max-w-7xl xl:max-w-full xl:mx-10  mx-auto sm:px-6">
                    <CreateNewElement
                        title={
                            query.role ? getTrans(pluralize(query.role)) : null
                        }
                        showSearch={true}
                        currentModule={getCurrentModule(currentRouteName)}
                    />
                    <div className="px-4 sm:px-6 ">
                        <div className="mt-8 flow-root">
                            <div className="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div className="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                    <MainTable
                                        columns={[
                                            "id",
                                            "name",
                                            "email",
                                            "roles",
                                            "membership",
                                            "more",
                                        ]}
                                    >
                                        {elements &&
                                            elements.data &&
                                            map(
                                                elements.data,
                                                (element: User, i: number) => (
                                                    <tr
                                                        key={i}
                                                        className="border-b border-gray-100"
                                                    >
                                                        <td className="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                                            {element.id}
                                                            <span>
                                                                <button
                                                                    disabled={
                                                                        !element.active
                                                                    }
                                                                    className={
                                                                        "flex-shrink-0 w-2.5 h-2.5 mx-6 border-2 rounded-full enabled:bg-green-400 disabled:bg-gray-200"
                                                                    }
                                                                    aria-hidden="true"
                                                                ></button>
                                                            </span>
                                                        </td>
                                                        <td className="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                            <div className="flex flex-row justify-start items-center gap-x-2">
                                                                <div>
                                                                    {element.image && (
                                                                        <img
                                                                            src={
                                                                                element.image
                                                                            }
                                                                            alt={
                                                                                element.name
                                                                            }
                                                                            className="block h-9 w-auto fill-current rounded-sm"
                                                                        />
                                                                    )}
                                                                </div>
                                                                <div>
                                                                    {
                                                                        element.name
                                                                    }
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td className="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                            {element.email}
                                                        </td>
                                                        <td className="whitespace-nowrap px-3 py-4 text-xs text-gray-500 font-extrabold">
                                                            {element.roles && (
                                                                <div
                                                                    className={`p-2 w-auto 2xl:w-1/2 text-center text-white text-xs truncate ${
                                                                        element
                                                                            .roles
                                                                            .name ===
                                                                        "company"
                                                                            ? `bg-sky-700 `
                                                                            : `bg-lime-600`
                                                                    } rounded-lg`}
                                                                >
                                                                    {getTrans(
                                                                        element
                                                                            .roles
                                                                            .name,
                                                                    )}
                                                                </div>
                                                            )}
                                                        </td>
                                                        <td>
                                                            {element.roles &&
                                                            element.roles
                                                                .name ===
                                                                "company" &&
                                                            !isEmpty(
                                                                element.deals,
                                                            ) ? (
                                                                <div className="flex flex-row justify-evenly xl:justify-start xl:gap-x-4 items-center">
                                                                    <div className="p-2 w-12 xl:w-24 text-center truncate rounded-md bg-gray-600 text-white text-xs">
                                                                        {
                                                                            element
                                                                                .deals
                                                                                .membership
                                                                                .name
                                                                        }
                                                                    </div>
                                                                    <div className="p-2 w-12 xl:w-24 text-center truncate rounded-md bg-green-600 text-white text-xs">
                                                                        {getTrans(
                                                                            element
                                                                                .deals
                                                                                .membership
                                                                                .sort,
                                                                        )}
                                                                    </div>
                                                                </div>
                                                            ) : (
                                                                getTrans("na")
                                                            )}
                                                        </td>
                                                        <td className="relative whitespace-nowrap  ltr:text-left rtl:text-right text-sm font-medium">
                                                            <Dropdown>
                                                                <Dropdown.Trigger>
                                                                    <span className="inline-flex rounded-md ">
                                                                        <button
                                                                            type="button"
                                                                            className="capitalize inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                                                                        >
                                                                            {getTrans(
                                                                                "more",
                                                                            )}
                                                                            <ArrowDownCircleIcon className="mx-2  h-4 w-4" />
                                                                        </button>
                                                                    </span>
                                                                </Dropdown.Trigger>
                                                                <Dropdown.Content>
                                                                    <Dropdown.Link
                                                                        href={route(
                                                                            `backend.user.edit`,
                                                                            {
                                                                                id: element.id,
                                                                            },
                                                                        )}
                                                                        className="text-gray-600 hover:text-gray-900"
                                                                    >
                                                                        {getTrans(
                                                                            "edit",
                                                                        )}
                                                                        <span className="sr-only">
                                                                            {
                                                                                element.name
                                                                            }
                                                                        </span>
                                                                    </Dropdown.Link>

                                                                    {/* {isAdmin &&
                                                                        query.role ===
                                                                            "company" && (
                                                                            <Dropdown.Link
                                                                                href={route(
                                                                                    `slide.index`,
                                                                                    {
                                                                                        search: `user_id=${element.id}`,
                                                                                    }
                                                                                )}
                                                                            >
                                                                                {getTrans(
                                                                                    "slides"
                                                                                )}
                                                                            </Dropdown.Link>
                                                                        )} */}

                                                                    <Dropdown.Link
                                                                        href={route(
                                                                            `backend.toggle.activate`,
                                                                            {
                                                                                model: getCurrentModule(
                                                                                    currentRouteName,
                                                                                ),
                                                                                id: element.id,
                                                                            },
                                                                        )}
                                                                    >
                                                                        {getTrans(
                                                                            "activate",
                                                                        )}
                                                                    </Dropdown.Link>
                                                                    {auth.isSuper && (
                                                                        <button
                                                                            className="text-red-600 hover:bg-red-600 hover:text-white w-full text-left flex ps-4 py-2 "
                                                                            onClick={() =>
                                                                                handleDelete(
                                                                                    element.id,
                                                                                )
                                                                            }
                                                                        >
                                                                            {getTrans(
                                                                                "delete",
                                                                            )}
                                                                        </button>
                                                                    )}
                                                                </Dropdown.Content>
                                                            </Dropdown>
                                                        </td>
                                                    </tr>
                                                ),
                                            )}
                                    </MainTable>
                                    {elements && elements.meta && (
                                        <Pagination
                                            links={elements.meta.links}
                                        />
                                    )}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
