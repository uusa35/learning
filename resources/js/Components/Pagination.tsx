import { Link } from "@inertiajs/react";
import { has, isEmpty, isNull, map } from "lodash";

type Props = {
    links: any;
};

export default function Pagination({ links }: Props): React.ReactNode {
    function getClassName(active: boolean) {
        if (active) {
            return "mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-gray-200 focus:border-primary focus:text-primary bg-gray-600 text-white hover:text-gray-900";
        } else {
            return "mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white hover:text-gray-900 focus:border-primary focus:text-primary";
        }
    }

    return (
        !isEmpty(links) && (
            <div className="bg-white my-6 rounded-md">
                <div className="flex flex-wrap  px-2 py-4 ">
                    {links &&
                        map(links, (link: any, i) =>
                            has(link, "url") && isNull(link.url) ? (
                                <div
                                    key={i}
                                    className="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded"
                                >
                                    {link.label}
                                </div>
                            ) : (
                                <Link
                                    key={i}
                                    className={getClassName(link.active)}
                                    href={link.url}
                                >
                                    {link.label}
                                </Link>
                            )
                        )}
                </div>
            </div>
        )
    );
}
