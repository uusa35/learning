import { getTrans } from "@/constants";
import { MagnifyingGlassIcon } from "@heroicons/react/24/outline";
import { Link, router, useForm, usePage } from "@inertiajs/react";
import { isNull, toString } from "lodash";
import pluralize from "pluralize";
import React from "react";

type Props = {
    title?: string | null;
    showSearch?: boolean;
    showReset?: boolean;
    currentModule: string;
    searchItem?: string;
};
export default function CreateNewElement({
    title = null,
    showSearch = false,
    showReset = false,
    currentModule,
    searchItem = `search`,
}: Props): React.ReactNode {
    const {
        props: {
            currentRouteName,
            ziggy: { query },
        },
    }: any = usePage();
    const { data, setData, get, reset, processing, progress } = useForm({
        search: query.search ?? ``,
        name: query.name ?? ``,
    });

    const handleSearch = (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        router.get(route(toString(currentRouteName).toString()), {
            ...(searchItem === "search"
                ? { search: data.search }
                : { name: data.search }),
        });
    };

    const handleChange = (e: React.ChangeEvent<HTMLInputElement>): void => {
        setData((values) => ({
            ...values,
            [e.target.id]: e.target.value,
        }));
    };

    const handleReset = () => {
        reset();
        return router.get(route(toString(currentRouteName)));
    };
    return (
        <div className="mx-7">
            <div className="grid grid-cols-1 md:grid-cols-5 w-full justify-end items-center gap-3">
                <div className="col-span-full md:col-span-1">
                    {/* title & description */}
                    <div className="flex  me-2">
                        <h1 className="text-lg font-semibold  text-gray-900 ">
                            {!isNull(title)
                                ? title
                                : getTrans(pluralize(currentModule))}
                        </h1>
                        <p className="text-sm text-gray-700 hidden">
                            A list of all the users in your account including
                            their name, title, email and role.
                        </p>
                    </div>
                </div>

                <div className="col-span-full md:col-span-3 xl:col-span-2 xl:col-start-3 gap-3 ">
                    {showSearch && (
                        <form
                            onSubmit={(e) => handleSearch(e)}
                            className="flex flex-col md:flex-row w-full items-center justify-between space-y-2 md:space-y-0 md:gap-x-2"
                        >
                            <div className="w-full flex-1">
                                <label htmlFor="search" className="sr-only">
                                    Search
                                </label>
                                <div className="relative text-gray-400 focus-within:text-gray-600">
                                    <div className="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <MagnifyingGlassIcon
                                            className="h-5 w-5"
                                            aria-hidden="true"
                                        />
                                    </div>
                                    <input
                                        id="search"
                                        className="block w-full rounded-md border-0 bg-white py-1.5 pl-10 pr-3 text-gray-900 focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-600 sm:text-sm sm:leading-6"
                                        placeholder={getTrans("search")}
                                        type="search"
                                        name="search"
                                        defaultValue={data.search}
                                        onChange={handleChange}
                                        required
                                    />
                                </div>
                            </div>
                            <div className="w-full flex flex-1 flex-col md:flex-row gap-2">
                                <div className="flex-1">
                                    <button
                                        disabled={processing}
                                        type="submit"
                                        className="default-btn bg-gray-600  hover:bg-gray-500 "
                                    >
                                        {getTrans("search")}
                                    </button>
                                </div>
                                <div className="flex-1">
                                    <button
                                        type="reset"
                                        onClick={handleReset}
                                        className="default-btn bg-red-600  hover:bg-red-500 "
                                    >
                                        {getTrans("reset")}
                                    </button>
                                </div>
                            </div>
                        </form>
                    )}
                </div>

                <div className="col-span-full md:col-span-1">
                    <Link
                        href={route(`backend.${currentModule}.create`)}
                        type="button"
                        className="default-btn bg-green-600  hover:bg-green-500"
                    >
                        {getTrans("add")} {getTrans(toString(currentModule))}
                    </Link>
                </div>
            </div>
        </div>
    );
}
