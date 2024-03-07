import AuthenticatedLayout from '@/layouts/AuthenticatedLayout';
import {Head, Link, router, useForm} from '@inertiajs/react';
import {PageProps} from '@/types/index.d';
import {Role, User} from '@/types/queries';
import {map, values, has, first, isObject, find, keys, get} from 'lodash';
import {getTrans, trans} from '@/constants';
import {FormEventHandler, useContext, useState} from 'react';
import InputLabel from '@/components/InputLabel';
import TextInput from '@/components/TextInput';
import InputError from '@/components/InputError';
import SunEditor, {buttonList} from 'suneditor-react';
import 'suneditor/dist/css/suneditor.min.css';
import {TextEditor} from '@/components/TextEditor';
import axios from 'axios';
import Select from 'react-select';

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
    categories: [] | undefined;
    tags: [] | undefined;
}

export default function ({
    countries,
    categories,
    tags,
    auth,
    setting,
    currentLang,
    currentRouteName,
}: PageProps) {
    const {data, setData, post, processing, errors, transform} =
        useForm<FormProps>({
            username: '',
            password: '',
            password_confirmation: '',
            email: '',
            image: '',
            country_id: '',
            role: '',
            name: {ar: '', en: '', ru: ''},
            description: {ar: '', en: '', ru: ''},
            caption: {ar: '', en: '', ru: ''},
            categories: [],
            tags: [],
        });

    const handleChange = (
        e:
            | React.ChangeEvent<HTMLInputElement>
            | React.ChangeEvent<HTMLSelectElement>,
    ): void => {
        setData((values: any) => ({
            ...values,
            [e.target.id]: e.target.value,
        }));
    };

    const submit: FormEventHandler = (e) => {
        e.preventDefault();
        post(route('user.store'), {preserveScroll: true});
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
                        <div>
                            <InputLabel
                                htmlFor="username"
                                value={getTrans('username')}
                                aria-required
                            />
                            <TextInput
                                id="username"
                                name="username"
                                required
                                aria-required
                                onChange={(e) => handleChange(e)}
                                value={data.username}
                                className="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"
                            />
                            <InputError
                                message={errors.username}
                                className="mt-2"
                            />
                        </div>

                        <div>
                            <InputLabel
                                htmlFor="email"
                                value={getTrans('email')}
                                aria-required
                            />
                            <TextInput
                                id="email"
                                name="email"
                                type="email"
                                required
                                aria-required
                                onChange={(e) => handleChange(e)}
                                value={data.email}
                                className="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"
                            />
                            <InputError
                                message={errors.email}
                                className="mt-2"
                            />
                        </div>

                        <div>
                            <InputLabel
                                htmlFor="password"
                                value={getTrans('password')}
                                aria-required
                            />
                            <TextInput
                                id="password"
                                name="password"
                                type="password"
                                required
                                aria-required
                                onChange={(e) => handleChange(e)}
                                value={data.password}
                                className="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"
                            />
                            <InputError
                                message={errors.password}
                                className="mt-2"
                                aria-required
                            />
                        </div>

                        <div>
                            <InputLabel
                                htmlFor="password_confirmation"
                                value={getTrans('password_confirmation')}
                                aria-required
                            />
                            <TextInput
                                id="password_confirmation"
                                name="password_confirmation"
                                type="password"
                                required
                                onChange={(e) => handleChange(e)}
                                value={data.password_confirmation}
                                className="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"
                            />
                            <InputError
                                message={errors.password_confirmation}
                                className="mt-2"
                            />
                        </div>

                        <div>
                            <InputLabel
                                htmlFor="country_id"
                                value={getTrans('country')}
                                aria-required
                            />
                            <select
                                onChange={(e) => handleChange(e)}
                                id="country_id"
                                name="country_id"
                                value={data.country_id}
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

                        {auth.isAdmin && (
                            <div>
                                <InputLabel
                                    htmlFor="role"
                                    value={getTrans('role')}
                                    aria-required
                                />
                                <select
                                    onChange={(e) => handleChange(e)}
                                    id="role"
                                    name="role"
                                    value={data.role}
                                    className="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"
                                >
                                    <option value="company">
                                        {getTrans('company')}
                                    </option>
                                    <option value="visitor">
                                        {getTrans('visitor')}
                                    </option>
                                </select>
                                <InputError
                                    message={get(errors, 'role')}
                                    className="mt-2"
                                />
                            </div>
                        )}
                        {categories ? (
                            <div>
                                <InputLabel
                                    htmlFor="categories"
                                    value={getTrans('categories')}
                                    aria-required
                                />
                                <Select
                                    isMulti
                                    name="categories"
                                    options={map(categories, (c: any, i) => {
                                        return {
                                            label: c.name,
                                            value: c.id,
                                        };
                                    })}
                                    onChange={(e: any) => {
                                        const categories: any = map(e, 'value');
                                        setData('categories', categories);
                                    }}
                                    className="basic-multi-select"
                                    classNamePrefix="select"
                                />
                                <InputError
                                    message={get(errors, 'categories')}
                                    className="mt-2"
                                />
                            </div>
                        ) : null}
                        {tags ? (
                            <div>
                                <InputLabel
                                    htmlFor="tags"
                                    value={getTrans('tags')}
                                    aria-required
                                />
                                <Select
                                    isMulti
                                    name="tags"
                                    options={map(tags, (t: any, i) => {
                                        return {
                                            label: t.name,
                                            value: t.id,
                                        };
                                    })}
                                    onChange={(e: any) => {
                                        const tags: any = map(e, 'value');
                                        setData('tags', tags);
                                    }}
                                    className="basic-multi-select"
                                    classNamePrefix="select"
                                />
                                <InputError
                                    message={get(errors, 'tags')}
                                    className="mt-2"
                                />
                            </div>
                        ) : null}

                        <div className="col-span-full grid grid-cols-1 lg:grid-cols-2">
                            <div className="col-span-1">
                                <InputLabel
                                    htmlFor="image"
                                    value={getTrans('logo')}
                                    aria-required
                                />
                                <input
                                    onChange={(e: any) =>
                                        setData('image', e.target?.files[0])
                                    }
                                    type="file"
                                    name="image"
                                    required
                                    id="main_image"
                                    accept="image/jpg, image/jpeg , image/png"
                                    className={`focus:ring-gray-500 focus:border-gray-500 block w-full border-gray-300 rounded-md`}
                                />
                                <InputError
                                    message={get(errors, 'image')}
                                    className="mt-2"
                                />
                            </div>
                        </div>
                    </div>
                    <div className="flex justify-end mt-6">
                        <button className="px-6 py-2 leading-5 text-white transition-colors duration-200 transform bg-gray-500 rounded-md hover:bg-gray-700 focus:outline-none focus:bg-gray-600">
                            {getTrans('save')}
                        </button>
                    </div>
                </section>
                <section className="max-w-4xl lg:max-w-full p-6 mx-auto lg:mx-10 bg-white rounded-md shadow-md dark:bg-gray-800">
                    <h2 className="text-lg font-semibold text-gray-700 capitalize dark:text-white">
                        Company Information
                    </h2>

                    <div className="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                        <div className="col-span-full grid grid-cols-1 lg:grid-cols-3 gap-4">
                            <div>
                                <InputLabel
                                    htmlFor="name[en]"
                                    value={getTrans('name_ar')}
                                    aria-required
                                />
                                <TextInput
                                    id="name[en]"
                                    name="name[en]"
                                    required
                                    aria-required
                                    onChange={(e) =>
                                        setData('name', {
                                            ...data.name,
                                            en: e.target.value,
                                        })
                                    }
                                    className="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"
                                />
                                <InputError
                                    message={get(errors, 'name.en')}
                                    className="mt-2"
                                />
                            </div>
                            <div>
                                <InputLabel
                                    htmlFor="name[ar]"
                                    value={getTrans('name_ar')}
                                    aria-required
                                />
                                <TextInput
                                    id="name[ar]"
                                    name="name[ar]"
                                    required
                                    aria-required
                                    onChange={(e) =>
                                        setData('name', {
                                            ...data.name,
                                            ar: e.target.value,
                                        })
                                    }
                                    className="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"
                                />
                                <InputError
                                    message={get(errors, 'name.ar')}
                                    className="mt-2"
                                />
                            </div>

                            <div>
                                <InputLabel
                                    htmlFor="name[ru]"
                                    value={getTrans('name_ru')}
                                    aria-required
                                />
                                <TextInput
                                    id="name[ru]"
                                    name="name[ru]"
                                    required
                                    aria-required
                                    onChange={(e) =>
                                        setData('name', {
                                            ...data.name,
                                            ru: e.target.value,
                                        })
                                    }
                                    className="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"
                                />
                                <InputError
                                    message={get(errors, 'name.ru')}
                                    className="mt-2"
                                />
                            </div>
                        </div>

                        <div className="col-span-full grid grid-cols-1 lg:grid-cols-3 gap-4">
                            <div>
                                <InputLabel
                                    htmlFor="caption[en]"
                                    value={getTrans('caption_en')}
                                    aria-required
                                />
                                <TextInput
                                    id="caption[en]"
                                    name="caption[en]"
                                    required
                                    aria-required
                                    onChange={(e) =>
                                        setData('caption', {
                                            ...data.name,
                                            en: e.target.value,
                                        })
                                    }
                                    className="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"
                                />
                                <InputError
                                    message={get(errors, 'caption.en')}
                                    className="mt-2"
                                />
                            </div>

                            <div>
                                <InputLabel
                                    htmlFor="name"
                                    value={getTrans('caption_ar')}
                                    aria-required
                                />
                                <TextInput
                                    id="caption[ar]"
                                    name="caption[ar]"
                                    required
                                    aria-required
                                    onChange={(e) =>
                                        setData('caption', {
                                            ...data.name,
                                            ar: e.target.value,
                                        })
                                    }
                                    className="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"
                                />
                                <InputError
                                    message={get(errors, 'caption.ar')}
                                    className="mt-2"
                                />
                            </div>

                            <div>
                                <InputLabel
                                    htmlFor="name"
                                    value={getTrans('caption_ru')}
                                    aria-required
                                />
                                <TextInput
                                    id="caption[ru]"
                                    name="caption[ru]"
                                    required
                                    aria-required
                                    onChange={(e) =>
                                        setData('caption', {
                                            ...data.name,
                                            ru: e.target.value,
                                        })
                                    }
                                    className="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"
                                />
                                <InputError
                                    message={get(errors, 'caption.ru')}
                                    className="mt-2"
                                />
                            </div>
                        </div>
                        {/* description */}
                        <div className="col-span-full">
                            <InputLabel
                                htmlFor="description[ar]"
                                value={getTrans('description.ar')}
                            />
                            <TextEditor
                                language="ar"
                                name="description"
                                setData={setData}
                                data={data}
                            />
                            <InputError
                                message={get(errors, 'description.ar')}
                                className="mt-2"
                            />
                        </div>
                        <div className="col-span-full">
                            <InputLabel
                                htmlFor="description[en]"
                                value={getTrans('description.en')}
                            />
                            <TextEditor
                                language="en"
                                name="description"
                                setData={setData}
                                data={data}
                            />
                            <InputError
                                message={get(errors, 'description.en')}
                                className="mt-2"
                            />
                        </div>
                        <div className="col-span-full">
                            <InputLabel
                                htmlFor="description[ru]"
                                value={getTrans('description.ru')}
                            />
                            <TextEditor
                                language="ru"
                                name="description"
                                setData={setData}
                                data={data}
                            />
                            <InputError
                                message={get(errors, 'description.ru')}
                                className="mt-2"
                            />
                        </div>
                    </div>

                    <div className="flex justify-end mt-6">
                        <button className="px-6 py-2 leading-5 text-white transition-colors duration-200 transform bg-gray-500 rounded-md hover:bg-gray-700 focus:outline-none focus:bg-gray-600">
                            {getTrans('save')}
                        </button>
                    </div>
                </section>
            </form>
        </AuthenticatedLayout>
    );
}
