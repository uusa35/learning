import { getTrans } from "@/constants";
import { HomeIcon } from "@heroicons/react/24/outline";
import { Link, usePage } from "@inertiajs/react";
import moment from "moment";

export default function () {
    const {
        props: { setting },
    }: any = usePage();
    return (
        <footer className="bg-white relative bottom-0 w-full">
            <div className="mx-auto max-w-7xl px-6 py-6 md:flex md:items-center md:justify-between lg:px-8">
                <div className="flex justify-center space-x-6 md:order-2">
                    <Link
                        href={"/"}
                        className="text-gray-400 hover:text-gray-500"
                    >
                        <HomeIcon className="text-black" />
                    </Link>
                </div>
                <div className=" md:order-1 md:mt-0">
                    <p className="text-center text-xs leading-5 text-gray-500">
                        {`@ ${getTrans("copyright")}${moment().year()} , ${
                            setting.name
                        }.`}
                    </p>
                </div>
            </div>
        </footer>
    );
}
