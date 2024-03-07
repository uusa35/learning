import AuthenticatedLayout from "@/layouts/AuthenticatedLayout";
import { Head, useForm } from "@inertiajs/react";
import { PageProps } from "@/types/index.d";
import { get, map } from "lodash";
import { getTrans } from "@/constants";
import { FormEventHandler, useState } from "react";
import InputLabel from "@/Components/InputLabel";
import TextInput from "@/Components/TextInput";
import InputError from "@/Components/InputError";
import "suneditor/dist/css/suneditor.min.css";
import { TextEditor } from "@/Components/TextEditor";
import Select from "react-select";
import { router } from "@inertiajs/react";
import { useAppDispatch } from "@/Redux/hooks";
import {
    showSuccessToastMessage,
    showWarningToastMessage,
} from "@/Redux/slices/toastMessageSlice";

interface FormProps {
    username: string;
    password: string;
    password_confirmation: string;
    email: string;
    image: string;
    country_id: string;
    role: string;
    name: any;
    description: any;
    caption: any;
    address: [] | undefined;
    categories: [] | undefined;
    tags: [] | undefined;
    mobile: string;
    phone: string;
    whatsapp: string;
    facebook: string;
    instagram: string;
    twitter: string;
    snap: string;
    tiktok: string;
    linked: string;
    iphone: string;
    android: string;
    longitude: string;
    latitude: string;
    keywords: string;
    website: string;
}

export default function UserEdit({
    element,
    countries,
    categories,
    tags,
    auth,
    currentRouteName,
}: PageProps) {
    const [currentImages, setCurrentImages] = useState([]);
    const dispatch = useAppDispatch();
    const { data, setData, post, put, processing, errors, transform, reset } =
        useForm({
            username: element.username,
            email: element.email,
            image: element.image,
            banner: element.banner,
            country_id: element.country_id,
            role: element.roles[0]?.name ?? `visitor`,
            name: {
                ar: element.name?.ar,
                en: element.name?.en,
                ru: element.name?.ru,
            },
            description: {
                ar: element.description?.ar,
                en: element.description?.en,
                ru: element.description?.ru,
            },
            caption: {
                ar: element.caption?.ar,
                en: element.caption?.en,
                ru: element.caption?.ru,
            },
            categories: map(element.categories, "id"),
            tags: map(element.tags, "id"),
            keywords: element.keywords,
            phone: element.phone,
            mobile: element.mobile,
            whatsapp: element.whatsapp,
            facebook: element.facebook,
            instagram: element.instagram,
            twitter: element.twitter,
            linked: element.linked,
            youtube: element.youtube,
            website: element.website,
            tiktok: element.tiktok,
            snap: element.snap,
            iphone: element.iphone,
            android: element.android,
            longitude: element.longitude,
            latitude: element.latitude,
            address: element.address,
            active: element.active,
            on_home: element.on_home,
            order: element.order,
        });

    const handleChange = (
        e:
            | React.ChangeEvent<HTMLInputElement>
            | React.ChangeEvent<HTMLSelectElement>
    ): void => {
        setData((values) => ({
            ...values,
            [e.target.id]: e.target.value,
        }));
    };

    const submit: FormEventHandler = (e) => {
        e.preventDefault();
        router.post(
            route("user.update", element.id),
            {
                _method: "put",
                ...data,
                image: data.image,
            },
            {
                forceFormData: true,
            }
        );
    };
    const handleImages = (imagesGroup: any) => {
        if (imagesGroup.length > 1 && imagesGroup.length <= 10 && element) {
            let formData = new FormData();
            const images: any = [];
            for (let i = 0; i < imagesGroup.length; i++) {
                formData.append(`images[${i}]`, imagesGroup[i]);
                images[`images[${i}]`] = imagesGroup[i];
            }
            router.visit(route("backend.image.upload"), {
                method: "post",
                data: {
                    id: element.id,
                    order: element.id,
                    model: "user",
                    ...images,
                },
                forceFormData: true,
                headers: {
                    Authorization: `Bearer ${auth.api_token}`,
                },
                onSuccess: (page) => {
                    dispatch(
                        showSuccessToastMessage({
                            content: getTrans("process_success"),
                        })
                    );
                },
                onError: () =>
                    dispatch(
                        showWarningToastMessage({
                            content: getTrans("process_failure"),
                        })
                    ),
                preserveScroll: false,
            });
        } else {
            dispatch(
                showWarningToastMessage({
                    content: getTrans(
                        "not_allowed_to_upload_more_than_10_or_less"
                    ),
                })
            );
        }
    };

    return (
        <AuthenticatedLayout header={currentRouteName} showBackBtn={true}>
            <Head title={getTrans(currentRouteName)} />
            <form onSubmit={submit} className="py-12 space-y-6">
                <section className="max-w-4xl lg:max-w-full p-6 mx-auto lg:mx-10 bg-white rounded-md shadow-md dark:bg-gray-800">
                    <h1 className="text-xl font-bold text-black capitalize dark:text-white">
                        Primary Information
                    </h1>
                    <div className="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                        {/* username */}
                        <div>
                            <InputLabel
                                htmlFor="username"
                                value={getTrans("username")}
                                aria-required
                            />
                            <TextInput
                                id="username"
                                name="username"
                                required
                                aria-required
                                onChange={(e) => handleChange(e)}
                                defaultValue={element.username}
                                className="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"
                            />
                            <InputError
                                message={errors.username}
                                className="mt-2"
                            />
                        </div>
                        {/* email */}
                        <div>
                            <InputLabel
                                htmlFor="email"
                                value={getTrans("email")}
                                aria-required
                            />
                            <TextInput
                                id="email"
                                name="email"
                                type="email"
                                required
                                aria-required
                                onChange={(e) => handleChange(e)}
                                defaultValue={element.email}
                                className="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"
                            />
                            <InputError
                                message={errors.email}
                                className="mt-2"
                            />
                        </div>

                        <div>
                            <InputLabel
                                htmlFor="country_id"
                                value={getTrans("country")}
                                aria-required
                            />
                            <select
                                onChange={(e) => handleChange(e)}
                                id="country_id"
                                name="country_id"
                                defaultValue={element.country_id}
                                required
                                className="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"
                            >
                                {map(countries, (c: any, i) => (
                                    <option value={c.id} key={i}>
                                        {c.name}
                                    </option>
                                ))}
                            </select>
                            <InputError
                                message={errors.country_id}
                                className="mt-2"
                            />
                        </div>
                        {/* role */}
                        {auth.isAdmin && (
                            <div>
                                <InputLabel
                                    htmlFor="role"
                                    value={getTrans("role")}
                                    aria-required
                                />
                                <select
                                    onChange={(e) => handleChange(e)}
                                    id="role"
                                    name="role"
                                    defaultValue={element.roles[0]?.name}
                                    className="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"
                                >
                                    <option value="company">
                                        {getTrans("company")}
                                    </option>
                                    <option value="visitor">
                                        {getTrans("visitor")}
                                    </option>
                                </select>
                                <InputError
                                    message={errors.role}
                                    className="mt-2"
                                />
                            </div>
                        )}
                        {categories ? (
                            <div className="col-span-2 pt-4">
                                <InputLabel
                                    htmlFor="categories"
                                    value={getTrans("categories")}
                                    aria-required
                                />
                                <Select
                                    defaultValue={map(
                                        element.categories,
                                        (c) => {
                                            return {
                                                label: c.name.en,
                                                value: c.id,
                                            };
                                        }
                                    )}
                                    isMulti
                                    required
                                    name="categories"
                                    options={map(categories, (c: any, i) => {
                                        return {
                                            label: c.name,
                                            value: c.id,
                                        };
                                    })}
                                    onChange={(e: any) =>
                                        setData("categories", map(e, "value"))
                                    }
                                    className="basic-multi-select"
                                    classNamePrefix="select"
                                />
                                <InputError
                                    message={get(errors, "categories")}
                                    className="mt-2"
                                />
                            </div>
                        ) : null}
                        {tags ? (
                            <div className="col-span-2 pt-4">
                                <InputLabel
                                    htmlFor="tags"
                                    value={getTrans("tags")}
                                    aria-required
                                />
                                <Select
                                    defaultValue={map(element.tags, (c) => {
                                        return {
                                            label: c.name.en,
                                            value: c.id,
                                        };
                                    })}
                                    isMulti
                                    required
                                    name="tags"
                                    options={map(tags, (c: any, i) => {
                                        return {
                                            label: c.name,
                                            value: c.id,
                                        };
                                    })}
                                    onChange={(e: any) =>
                                        setData("tags", map(e, "value"))
                                    }
                                    className="basic-multi-select"
                                    classNamePrefix="select"
                                />
                                <InputError
                                    message={get(errors, "tags")}
                                    className="mt-2"
                                />
                            </div>
                        ) : null}

                        {/* image */}
                        <div className="col-span-full grid grid-cols-1 lg:grid-cols-3">
                            <div className="col-span-1 flex-row">
                                <InputLabel
                                    htmlFor="image"
                                    value={getTrans("logo")}
                                    aria-required
                                />
                                <div className="flex flex-row gap-x-4 my-4">
                                    <div>
                                        <img
                                            src={element.thumb}
                                            className="w-20 h-auto rounded-md"
                                        />
                                    </div>
                                    <input
                                        onChange={(e: any) =>
                                            setData("image", e.target?.files[0])
                                        }
                                        type="file"
                                        name="image"
                                        id="image"
                                        accept="image/jpg, image/jpeg , image/png"
                                        className={`focus:ring-gray-500 focus:border-gray-500 block w-full border-gray-300 rounded-md`}
                                    />
                                </div>
                            </div>

                            <div className="col-span-1 flex-row">
                                <InputLabel
                                    htmlFor="banner"
                                    value={getTrans("banner")}
                                />
                                <div className="flex flex-row gap-x-4 my-4">
                                    <div>
                                        <img
                                            src={element.banner}
                                            className="w-20 h-auto rounded-md"
                                        />
                                    </div>
                                    <input
                                        onChange={(e: any) =>
                                            setData(
                                                "banner",
                                                e.target?.files[0]
                                            )
                                        }
                                        type="file"
                                        name="banner"
                                        id="banner"
                                        accept="image/jpg, image/jpeg , image/png"
                                        className={`focus:ring-gray-500 focus:border-gray-500 block w-full border-gray-300 rounded-md`}
                                    />
                                </div>
                            </div>

                            {/* more images */}
                            <div className="col-span-1">
                                <InputLabel
                                    htmlFor="more_images"
                                    value={getTrans("gallery")}
                                />
                                <input
                                    onChange={(e) =>
                                        handleImages(e.target.files)
                                    }
                                    type="file"
                                    multiple
                                    name="images"
                                    id="more_images"
                                    accept="image/jpg, image/jpeg , image/png"
                                    autoComplete="more_images"
                                    className={`pt-3.5 focus:ring-gray-500 focus:border-gray-500 block w-full border-gray-300 rounded-md`}
                                />
                            </div>
                        </div>
                    </div>
                    <div className="flex justify-end mt-6">
                        <button className="px-6 py-2 leading-5 text-white transition-colors duration-200 transform bg-gray-500 rounded-md hover:bg-gray-700 focus:outline-none focus:bg-gray-600">
                            {getTrans("save")}
                        </button>
                    </div>
                </section>

                <section className="max-w-4xl lg:max-w-full p-6 mx-auto lg:mx-10 bg-white rounded-md shadow-md dark:bg-gray-800">
                    <h2 className="text-lg font-semibold text-gray-700 capitalize dark:text-white">
                        Company Information
                    </h2>

                    <div className="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                        {/*  name  */}
                        <div className="col-span-full grid grid-cols-1 lg:grid-cols-3 gap-4">
                            <div>
                                <InputLabel
                                    htmlFor="name[en]"
                                    value={getTrans("name_en")}
                                    aria-required
                                />
                                <TextInput
                                    defaultValue={element.name?.en}
                                    id="name[en]"
                                    name="name[en]"
                                    required
                                    aria-required
                                    onChange={(e) =>
                                        setData("name", {
                                            ...data.name,
                                            en: e.target.value,
                                        })
                                    }
                                    className="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"
                                />
                                <InputError
                                    message={get(errors, "name.en")}
                                    className="mt-2"
                                />
                            </div>
                            <div>
                                <InputLabel
                                    htmlFor="name[ar]"
                                    value={getTrans("name_ar")}
                                    aria-required
                                />
                                <TextInput
                                    defaultValue={element.name?.ar}
                                    id="name[ar]"
                                    name="name[ar]"
                                    required
                                    aria-required
                                    onChange={(e) =>
                                        setData("name", {
                                            ...data.name,
                                            ar: e.target.value,
                                        })
                                    }
                                    className="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"
                                />
                                <InputError
                                    message={get(errors, "name.ar")}
                                    className="mt-2"
                                />
                            </div>

                            <div>
                                <InputLabel
                                    htmlFor="name[ru]"
                                    value={getTrans("name_ru")}
                                    aria-required
                                />
                                <TextInput
                                    defaultValue={element.name?.ru}
                                    id="name[ru]"
                                    name="name[ru]"
                                    required
                                    aria-required
                                    onChange={(e) =>
                                        setData("name", {
                                            ...data.name,
                                            ru: e.target.value,
                                        })
                                    }
                                    className="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"
                                />
                                <InputError
                                    message={get(errors, "name.ru")}
                                    className="mt-2"
                                />
                            </div>
                        </div>
                        {/* caption */}
                        <div className="col-span-full grid grid-cols-1 lg:grid-cols-3 gap-4">
                            <div>
                                <InputLabel
                                    htmlFor="caption[en]"
                                    value={getTrans("caption_en")}
                                    aria-required
                                />
                                <TextInput
                                    defaultValue={element.caption?.en}
                                    id="caption[en]"
                                    name="caption[en]"
                                    required
                                    aria-required
                                    onChange={(e) =>
                                        setData("caption", {
                                            ...data.name,
                                            en: e.target.value,
                                        })
                                    }
                                    className="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"
                                />
                                <InputError
                                    message={get(errors, "caption.en")}
                                    className="mt-2"
                                />
                            </div>

                            <div>
                                <InputLabel
                                    htmlFor="name"
                                    value={getTrans("caption_ar")}
                                    aria-required
                                />
                                <TextInput
                                    defaultValue={element.caption?.ar}
                                    id="caption[ar]"
                                    name="caption[ar]"
                                    required
                                    aria-required
                                    onChange={(e) =>
                                        setData("caption", {
                                            ...data.name,
                                            ar: e.target.value,
                                        })
                                    }
                                    className="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"
                                />
                                <InputError
                                    message={get(errors, "caption.ar")}
                                    className="mt-2"
                                />
                            </div>

                            <div>
                                <InputLabel
                                    htmlFor="name"
                                    value={getTrans("caption_ru")}
                                    aria-required
                                />
                                <TextInput
                                    defaultValue={element.caption?.ru}
                                    id="caption[ru]"
                                    name="caption[ru]"
                                    required
                                    aria-required
                                    onChange={(e) =>
                                        setData("caption", {
                                            ...data.name,
                                            ru: e.target.value,
                                        })
                                    }
                                    className="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"
                                />
                                <InputError
                                    message={get(errors, "caption.ru")}
                                    className="mt-2"
                                />
                            </div>
                        </div>
                        {/* description[ar] */}
                        <div className="col-span-full">
                            <InputLabel
                                htmlFor="description[ar]"
                                value={getTrans("description.ar")}
                            />
                            <TextEditor
                                language="ar"
                                name="description"
                                setData={setData}
                                data={data}
                                defaultValue={element.description?.ar}
                            />
                            <InputError
                                message={get(errors, "description.ar")}
                                className="mt-2"
                            />
                        </div>
                        {/* descirption[en] */}
                        <div className="col-span-full">
                            <InputLabel
                                htmlFor="description[en]"
                                value={getTrans("description.en")}
                            />
                            <TextEditor
                                defaultValue={element.description?.en}
                                language="en"
                                name="description"
                                setData={setData}
                                data={data}
                            />
                            <InputError
                                message={get(errors, "description.en")}
                                className="mt-2"
                            />
                        </div>
                        {/* descrption[ru] */}
                        <div className="col-span-full">
                            <InputLabel
                                htmlFor="description[ru]"
                                value={getTrans("description.ru")}
                            />
                            <TextEditor
                                defaultValue={element.description?.ru}
                                language="ru"
                                name="description"
                                setData={setData}
                                data={data}
                            />
                            <InputError
                                message={get(errors, "description.ru")}
                                className="mt-2"
                            />
                        </div>
                    </div>

                    <div className="flex justify-end mt-6">
                        <button className="px-6 py-2 leading-5 text-white transition-colors duration-200 transform bg-gray-500 rounded-md hover:bg-gray-700 focus:outline-none focus:bg-gray-600">
                            {getTrans("save")}
                        </button>
                    </div>
                </section>

                {/*  more information */}
                <section className="max-w-4xl lg:max-w-full p-6 mx-auto lg:mx-10 bg-white rounded-md shadow-md dark:bg-gray-800">
                    <h2 className="text-lg font-semibold text-gray-700 capitalize dark:text-white">
                        More Information
                    </h2>
                    {/* rest of information */}
                    <div className="col-span-full grid grid-cols-1 lg:grid-cols-3 gap-4 mt-8">
                        {/* address */}
                        <div>
                            <InputLabel
                                htmlFor="address"
                                value={getTrans("address")}
                            />
                            <TextInput
                                defaultValue={element.address}
                                id="address"
                                name="address[0]"
                                type="text"
                                onChange={(e) =>
                                    setData("address", [e.target.value])
                                }
                                className="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"
                            />
                            <InputError
                                message={get(errors, "address")}
                                className="mt-2"
                            />
                        </div>
                        {/* phone */}
                        <div>
                            <InputLabel
                                htmlFor="phone"
                                value={getTrans("phone")}
                            />
                            <TextInput
                                defaultValue={element.phone}
                                id="phone"
                                name="phone"
                                type="text"
                                onChange={(e) =>
                                    setData("phone", e.target.value)
                                }
                                className="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"
                            />
                            <InputError
                                message={get(errors, "phone")}
                                className="mt-2"
                            />
                        </div>
                        {/* whatsapp */}
                        <div>
                            <InputLabel
                                htmlFor="whatsapp"
                                value={getTrans("whatsapp")}
                            />
                            <TextInput
                                defaultValue={element.whatsapp}
                                id="whatsapp"
                                name="whatsapp"
                                type="text"
                                onChange={(e) =>
                                    setData("whatsapp", e.target.value)
                                }
                                className="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"
                            />
                            <InputError
                                message={get(errors, "whatsapp")}
                                className="mt-2"
                            />
                        </div>
                        {/* mobile */}
                        <div>
                            <InputLabel
                                htmlFor="mobile"
                                value={getTrans("mobile")}
                            />
                            <TextInput
                                defaultValue={element.mobile}
                                id="mobile"
                                type="text"
                                name="mobile"
                                onChange={(e) =>
                                    setData("mobile", e.target.value)
                                }
                                className="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"
                            />
                            <InputError
                                message={get(errors, "mobile")}
                                className="mt-2"
                            />
                        </div>
                        {/* website */}
                        <div>
                            <InputLabel
                                htmlFor="website"
                                value={getTrans("website")}
                            />
                            <TextInput
                                defaultValue={element.website}
                                id="website"
                                type="url"
                                name="website"
                                onChange={(e) =>
                                    setData("website", e.target.value)
                                }
                                className="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"
                            />
                            <InputError
                                message={get(errors, "website")}
                                className="mt-2"
                            />
                        </div>
                        {/* facebook */}
                        <div>
                            <InputLabel
                                htmlFor="facebook"
                                value={getTrans("facebook")}
                            />
                            <TextInput
                                defaultValue={element.facebook}
                                id="facebook"
                                type="url"
                                name="facebook"
                                onChange={(e) =>
                                    setData("facebook", e.target.value)
                                }
                                className="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"
                            />
                            <InputError
                                message={get(errors, "facebook")}
                                className="mt-2"
                            />
                        </div>
                        {/* twitter */}
                        <div>
                            <InputLabel
                                htmlFor="twitter"
                                value={getTrans("twitter")}
                            />
                            <TextInput
                                defaultValue={element.twitter}
                                id="twitter"
                                type="url"
                                name="twitter"
                                onChange={(e) =>
                                    setData("twitter", e.target.value)
                                }
                                className="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"
                            />
                            <InputError
                                message={get(errors, "twitter")}
                                className="mt-2"
                            />
                        </div>
                        {/* instagram */}
                        <div>
                            <InputLabel
                                htmlFor="instagram"
                                value={getTrans("instagram")}
                            />
                            <TextInput
                                defaultValue={element.instagram}
                                id="instagram"
                                name="instagram"
                                type="url"
                                onChange={(e) =>
                                    setData("instagram", e.target.value)
                                }
                                className="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"
                            />
                            <InputError
                                message={get(errors, "instagram")}
                                className="mt-2"
                            />
                        </div>
                        {/* youtube */}
                        <div>
                            <InputLabel
                                htmlFor="youtube"
                                value={getTrans("youtube")}
                            />
                            <TextInput
                                defaultValue={element.youtube}
                                id="youtube"
                                name="youtube"
                                type="url"
                                onChange={(e) =>
                                    setData("youtube", e.target.value)
                                }
                                className="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"
                            />
                            <InputError
                                message={get(errors, "youtube")}
                                className="mt-2"
                            />
                        </div>
                        {/* snap */}
                        <div>
                            <InputLabel
                                htmlFor="snap"
                                value={getTrans("snap")}
                            />
                            <TextInput
                                defaultValue={element.snap}
                                id="snap"
                                name="snap"
                                type="url"
                                onChange={(e) =>
                                    setData("snap", e.target.value)
                                }
                                className="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"
                            />
                            <InputError
                                message={get(errors, "snap")}
                                className="mt-2"
                            />
                        </div>
                        {/* iphone */}
                        <div>
                            <InputLabel
                                htmlFor="iphone"
                                value={getTrans("iphone")}
                            />
                            <TextInput
                                defaultValue={element.iphone}
                                id="iphone"
                                name="iphone"
                                type="url"
                                onChange={(e) =>
                                    setData("iphone", e.target.value)
                                }
                                className="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"
                            />
                            <InputError
                                message={get(errors, "iphone")}
                                className="mt-2"
                            />
                        </div>
                        {/* android */}
                        <div>
                            <InputLabel
                                htmlFor="android"
                                value={getTrans("android")}
                            />
                            <TextInput
                                defaultValue={element.android}
                                id="android"
                                name="android"
                                type="url"
                                onChange={(e) =>
                                    setData("android", e.target.value)
                                }
                                className="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"
                            />
                            <InputError
                                message={get(errors, "android")}
                                className="mt-2"
                            />
                        </div>
                        {/* tiktok */}
                        <div>
                            <InputLabel
                                htmlFor="tiktok"
                                value={getTrans("tiktok")}
                            />
                            <TextInput
                                defaultValue={element.tiktok}
                                id="tiktok"
                                name="tiktok"
                                type="url"
                                onChange={(e) =>
                                    setData("tiktok", e.target.value)
                                }
                                className="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"
                            />
                            <InputError
                                message={get(errors, "tiktok")}
                                className="mt-2"
                            />
                        </div>
                        {/* linked */}
                        <div>
                            <InputLabel
                                htmlFor="linked"
                                value={getTrans("linked")}
                            />
                            <TextInput
                                defaultValue={element.linked}
                                id="linked"
                                name="linked"
                                type="url"
                                onChange={(e) =>
                                    setData("linked", e.target.value)
                                }
                                className="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"
                            />
                            <InputError
                                message={get(errors, "linked")}
                                className="mt-2"
                            />
                        </div>
                        {/* keywords */}
                        <div>
                            <InputLabel
                                htmlFor="keywords"
                                value={getTrans("keywords")}
                            />
                            <TextInput
                                defaultValue={element.keywords}
                                id="keywords"
                                name="keywords"
                                type="text"
                                onChange={(e) =>
                                    setData("keywords", e.target.value)
                                }
                                className="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"
                            />
                            <InputError
                                message={get(errors, "keywords")}
                                className="mt-2"
                            />
                        </div>
                        {/* longitude */}
                        <div>
                            <InputLabel
                                htmlFor="longitude"
                                value={getTrans("longitude")}
                            />
                            <TextInput
                                defaultValue={element.longitude}
                                id="longitude"
                                name="longitude"
                                type="text"
                                onChange={(e) =>
                                    setData("longitude", e.target.value)
                                }
                                className="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"
                            />
                            <InputError
                                message={get(errors, "longitude")}
                                className="mt-2"
                            />
                        </div>
                        {/* latitude */}
                        <div>
                            <InputLabel
                                htmlFor="latitude"
                                value={getTrans("latitude")}
                            />
                            <TextInput
                                defaultValue={element.latitude}
                                id="latitude"
                                name="latitude"
                                type="text"
                                onChange={(e) =>
                                    setData("latitude", e.target.value)
                                }
                                className="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"
                            />
                            <InputError
                                message={get(errors, "latitude")}
                                className="mt-2"
                            />
                        </div>
                    </div>
                    <div className="flex justify-end mt-6">
                        <button className="px-6 py-2 leading-5 text-white transition-colors duration-200 transform bg-gray-500 rounded-md hover:bg-gray-700 focus:outline-none focus:bg-gray-600">
                            {getTrans("save")}
                        </button>
                    </div>
                </section>

                {auth.isAdmin && (
                    <section className="max-w-4xl lg:max-w-full p-6 mx-auto lg:mx-10 bg-white rounded-md shadow-md dark:bg-gray-800">
                        <h2 className="text-lg font-semibold text-gray-700 capitalize dark:text-white">
                            {getTrans("more_info")}
                        </h2>

                        <div className="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                            <div className="col-span-full grid grid-cols-1 lg:grid-cols-3 gap-4">
                                {/* order */}
                                <div>
                                    <InputLabel
                                        htmlFor="order"
                                        value={getTrans("order")}
                                    />
                                    <TextInput
                                        id="order"
                                        name="order"
                                        type="number"
                                        onChange={handleChange}
                                        defaultValue={element.order}
                                        className="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"
                                    />
                                    <InputError
                                        message={get(errors, "order")}
                                        className="mt-2"
                                    />
                                </div>
                                {/* on_home */}
                                <div>
                                    <InputLabel
                                        htmlFor="on_home"
                                        value={getTrans("on_home")}
                                    />
                                    <div className="flex w-60 flex-row gap-4 py-4">
                                        <input
                                            id="on_home"
                                            name="on_home"
                                            type="radio"
                                            value={1}
                                            onChange={handleChange}
                                            defaultChecked={data.on_home}
                                            className=" text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"
                                        />
                                        <span>{getTrans("active")}</span>
                                        <input
                                            id="on_home"
                                            name="on_home"
                                            type="radio"
                                            value={0}
                                            onChange={handleChange}
                                            defaultChecked={!data.on_home}
                                            className=" text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"
                                        />
                                        <span>{getTrans("inactive")}</span>
                                    </div>
                                    <InputError
                                        message={get(errors, "on_home")}
                                        className="mt-2"
                                    />
                                </div>

                                {/* active */}
                                <div>
                                    <InputLabel
                                        htmlFor="active"
                                        value={getTrans("active")}
                                    />
                                    <div className="flex w-60 flex-row gap-4 py-4">
                                        <input
                                            id="active"
                                            name="active"
                                            type="radio"
                                            value={1}
                                            onChange={handleChange}
                                            defaultChecked={data.active}
                                            className=" text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"
                                        />
                                        <span>{getTrans("active")}</span>
                                        <input
                                            id="active"
                                            name="active"
                                            type="radio"
                                            value={0}
                                            area-aria-label="testing"
                                            onChange={handleChange}
                                            defaultChecked={!data.active}
                                            className=" text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"
                                        />
                                        <span>{getTrans("inactive")}</span>
                                    </div>
                                    <InputError
                                        message={get(errors, "active")}
                                        className="mt-2"
                                    />
                                </div>
                            </div>
                        </div>

                        <div className="flex justify-end mt-6">
                            <button className="px-6 py-2 leading-5 text-white transition-colors duration-200 transform bg-gray-500 rounded-md hover:bg-gray-700 focus:outline-none focus:bg-gray-600">
                                {getTrans("save")}
                            </button>
                        </div>
                    </section>
                )}
            </form>
        </AuthenticatedLayout>
    );
}
