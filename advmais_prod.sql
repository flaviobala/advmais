--
-- PostgreSQL database dump
--

\restrict KMKev2yrngI64zq3Ai4BHE3hUiIdKLBEmxPMYcXvHnbidm9WtpzAWjF8AAAGaEQ

-- Dumped from database version 16.11 (Ubuntu 16.11-0ubuntu0.24.04.1)
-- Dumped by pg_dump version 16.11 (Ubuntu 16.11-0ubuntu0.24.04.1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: public; Type: SCHEMA; Schema: -; Owner: advmais_user
--

-- *not* creating schema, since initdb creates it


ALTER SCHEMA public OWNER TO advmais_user;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: about_events; Type: TABLE; Schema: public; Owner: advmais_user
--

CREATE TABLE public.about_events (
    id bigint NOT NULL,
    title character varying(255) NOT NULL,
    description text,
    photo character varying(255),
    video_url character varying(255),
    "order" integer DEFAULT 0 NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.about_events OWNER TO advmais_user;

--
-- Name: about_events_id_seq; Type: SEQUENCE; Schema: public; Owner: advmais_user
--

CREATE SEQUENCE public.about_events_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.about_events_id_seq OWNER TO advmais_user;

--
-- Name: about_events_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: advmais_user
--

ALTER SEQUENCE public.about_events_id_seq OWNED BY public.about_events.id;


--
-- Name: about_founders; Type: TABLE; Schema: public; Owner: advmais_user
--

CREATE TABLE public.about_founders (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    role character varying(255),
    bio text,
    photo character varying(255),
    "order" integer DEFAULT 0 NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.about_founders OWNER TO advmais_user;

--
-- Name: about_founders_id_seq; Type: SEQUENCE; Schema: public; Owner: advmais_user
--

CREATE SEQUENCE public.about_founders_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.about_founders_id_seq OWNER TO advmais_user;

--
-- Name: about_founders_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: advmais_user
--

ALTER SEQUENCE public.about_founders_id_seq OWNED BY public.about_founders.id;


--
-- Name: about_settings; Type: TABLE; Schema: public; Owner: advmais_user
--

CREATE TABLE public.about_settings (
    id bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    intro_video_url character varying(255),
    intro_text text,
    card_image character varying(255)
);


ALTER TABLE public.about_settings OWNER TO advmais_user;

--
-- Name: about_settings_id_seq; Type: SEQUENCE; Schema: public; Owner: advmais_user
--

CREATE SEQUENCE public.about_settings_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.about_settings_id_seq OWNER TO advmais_user;

--
-- Name: about_settings_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: advmais_user
--

ALTER SEQUENCE public.about_settings_id_seq OWNED BY public.about_settings.id;


--
-- Name: categories; Type: TABLE; Schema: public; Owner: advmais_user
--

CREATE TABLE public.categories (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    slug character varying(255) NOT NULL,
    description text,
    "order" integer DEFAULT 0 NOT NULL,
    is_active boolean DEFAULT true NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    cover_image character varying(255)
);


ALTER TABLE public.categories OWNER TO advmais_user;

--
-- Name: categories_id_seq; Type: SEQUENCE; Schema: public; Owner: advmais_user
--

CREATE SEQUENCE public.categories_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.categories_id_seq OWNER TO advmais_user;

--
-- Name: categories_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: advmais_user
--

ALTER SEQUENCE public.categories_id_seq OWNED BY public.categories.id;


--
-- Name: courses; Type: TABLE; Schema: public; Owner: advmais_user
--

CREATE TABLE public.courses (
    id bigint NOT NULL,
    title character varying(255) NOT NULL,
    description text,
    cover_image character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    is_active boolean DEFAULT true NOT NULL,
    preview_video_provider character varying(255),
    preview_video_id character varying(255),
    category_id bigint,
    course_video character varying(255),
    is_approved boolean DEFAULT true NOT NULL,
    created_by bigint,
    thumbnail character varying(255)
);


ALTER TABLE public.courses OWNER TO advmais_user;

--
-- Name: courses_id_seq; Type: SEQUENCE; Schema: public; Owner: advmais_user
--

CREATE SEQUENCE public.courses_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.courses_id_seq OWNER TO advmais_user;

--
-- Name: courses_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: advmais_user
--

ALTER SEQUENCE public.courses_id_seq OWNED BY public.courses.id;


--
-- Name: lesson_attachments; Type: TABLE; Schema: public; Owner: advmais_user
--

CREATE TABLE public.lesson_attachments (
    id bigint NOT NULL,
    lesson_id bigint NOT NULL,
    filename character varying(255) NOT NULL,
    filepath character varying(255) NOT NULL,
    filetype character varying(255) NOT NULL,
    filesize bigint,
    "order" integer DEFAULT 0 NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.lesson_attachments OWNER TO advmais_user;

--
-- Name: lesson_attachments_id_seq; Type: SEQUENCE; Schema: public; Owner: advmais_user
--

CREATE SEQUENCE public.lesson_attachments_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.lesson_attachments_id_seq OWNER TO advmais_user;

--
-- Name: lesson_attachments_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: advmais_user
--

ALTER SEQUENCE public.lesson_attachments_id_seq OWNED BY public.lesson_attachments.id;


--
-- Name: lesson_user; Type: TABLE; Schema: public; Owner: advmais_user
--

CREATE TABLE public.lesson_user (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    lesson_id bigint NOT NULL,
    is_completed boolean DEFAULT false NOT NULL,
    progress_percentage integer DEFAULT 0 NOT NULL,
    completed_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.lesson_user OWNER TO advmais_user;

--
-- Name: lesson_user_access; Type: TABLE; Schema: public; Owner: advmais_user
--

CREATE TABLE public.lesson_user_access (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    lesson_id bigint NOT NULL,
    available_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.lesson_user_access OWNER TO advmais_user;

--
-- Name: lesson_user_access_id_seq; Type: SEQUENCE; Schema: public; Owner: advmais_user
--

CREATE SEQUENCE public.lesson_user_access_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.lesson_user_access_id_seq OWNER TO advmais_user;

--
-- Name: lesson_user_access_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: advmais_user
--

ALTER SEQUENCE public.lesson_user_access_id_seq OWNED BY public.lesson_user_access.id;


--
-- Name: lesson_user_id_seq; Type: SEQUENCE; Schema: public; Owner: advmais_user
--

CREATE SEQUENCE public.lesson_user_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.lesson_user_id_seq OWNER TO advmais_user;

--
-- Name: lesson_user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: advmais_user
--

ALTER SEQUENCE public.lesson_user_id_seq OWNED BY public.lesson_user.id;


--
-- Name: lessons; Type: TABLE; Schema: public; Owner: advmais_user
--

CREATE TABLE public.lessons (
    id bigint NOT NULL,
    course_id bigint NOT NULL,
    title character varying(255) NOT NULL,
    "order" integer DEFAULT 0 NOT NULL,
    video_provider character varying(255) DEFAULT 'vimeo'::character varying NOT NULL,
    video_ref_id character varying(255) NOT NULL,
    duration_seconds integer,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    attachment character varying(255),
    is_active boolean DEFAULT true NOT NULL,
    module_id bigint,
    description text
);


ALTER TABLE public.lessons OWNER TO advmais_user;

--
-- Name: lessons_id_seq; Type: SEQUENCE; Schema: public; Owner: advmais_user
--

CREATE SEQUENCE public.lessons_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.lessons_id_seq OWNER TO advmais_user;

--
-- Name: lessons_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: advmais_user
--

ALTER SEQUENCE public.lessons_id_seq OWNED BY public.lessons.id;


--
-- Name: materials; Type: TABLE; Schema: public; Owner: advmais_user
--

CREATE TABLE public.materials (
    id bigint NOT NULL,
    materialable_type character varying(255) NOT NULL,
    materialable_id bigint NOT NULL,
    type character varying(255) DEFAULT 'file'::character varying NOT NULL,
    title character varying(255),
    filename character varying(255),
    filepath character varying(255),
    filetype character varying(255),
    filesize bigint,
    url character varying(255),
    "order" integer DEFAULT 0 NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    cover_image character varying(255),
    description text,
    CONSTRAINT materials_type_check CHECK (((type)::text = ANY ((ARRAY['file'::character varying, 'link'::character varying])::text[])))
);


ALTER TABLE public.materials OWNER TO advmais_user;

--
-- Name: materials_id_seq; Type: SEQUENCE; Schema: public; Owner: advmais_user
--

CREATE SEQUENCE public.materials_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.materials_id_seq OWNER TO advmais_user;

--
-- Name: materials_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: advmais_user
--

ALTER SEQUENCE public.materials_id_seq OWNED BY public.materials.id;


--
-- Name: migrations; Type: TABLE; Schema: public; Owner: advmais_user
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO advmais_user;

--
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: advmais_user
--

CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.migrations_id_seq OWNER TO advmais_user;

--
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: advmais_user
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- Name: modules; Type: TABLE; Schema: public; Owner: advmais_user
--

CREATE TABLE public.modules (
    id bigint NOT NULL,
    course_id bigint NOT NULL,
    title character varying(255) NOT NULL,
    description text,
    "order" integer DEFAULT 0 NOT NULL,
    is_active boolean DEFAULT true NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    cover_image character varying(255)
);


ALTER TABLE public.modules OWNER TO advmais_user;

--
-- Name: modules_id_seq; Type: SEQUENCE; Schema: public; Owner: advmais_user
--

CREATE SEQUENCE public.modules_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.modules_id_seq OWNER TO advmais_user;

--
-- Name: modules_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: advmais_user
--

ALTER SEQUENCE public.modules_id_seq OWNED BY public.modules.id;


--
-- Name: password_reset_tokens; Type: TABLE; Schema: public; Owner: advmais_user
--

CREATE TABLE public.password_reset_tokens (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);


ALTER TABLE public.password_reset_tokens OWNER TO advmais_user;

--
-- Name: personal_access_tokens; Type: TABLE; Schema: public; Owner: advmais_user
--

CREATE TABLE public.personal_access_tokens (
    id bigint NOT NULL,
    tokenable_type character varying(255) NOT NULL,
    tokenable_id bigint NOT NULL,
    name text NOT NULL,
    token character varying(64) NOT NULL,
    abilities text,
    last_used_at timestamp(0) without time zone,
    expires_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.personal_access_tokens OWNER TO advmais_user;

--
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE; Schema: public; Owner: advmais_user
--

CREATE SEQUENCE public.personal_access_tokens_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.personal_access_tokens_id_seq OWNER TO advmais_user;

--
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: advmais_user
--

ALTER SEQUENCE public.personal_access_tokens_id_seq OWNED BY public.personal_access_tokens.id;


--
-- Name: sessions; Type: TABLE; Schema: public; Owner: advmais_user
--

CREATE TABLE public.sessions (
    id character varying(255) NOT NULL,
    user_id bigint,
    ip_address character varying(45),
    user_agent text,
    payload text NOT NULL,
    last_activity integer NOT NULL
);


ALTER TABLE public.sessions OWNER TO advmais_user;

--
-- Name: user_category; Type: TABLE; Schema: public; Owner: advmais_user
--

CREATE TABLE public.user_category (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    category_id bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.user_category OWNER TO advmais_user;

--
-- Name: user_category_id_seq; Type: SEQUENCE; Schema: public; Owner: advmais_user
--

CREATE SEQUENCE public.user_category_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.user_category_id_seq OWNER TO advmais_user;

--
-- Name: user_category_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: advmais_user
--

ALTER SEQUENCE public.user_category_id_seq OWNED BY public.user_category.id;


--
-- Name: user_course; Type: TABLE; Schema: public; Owner: advmais_user
--

CREATE TABLE public.user_course (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    course_id bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.user_course OWNER TO advmais_user;

--
-- Name: user_course_id_seq; Type: SEQUENCE; Schema: public; Owner: advmais_user
--

CREATE SEQUENCE public.user_course_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.user_course_id_seq OWNER TO advmais_user;

--
-- Name: user_course_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: advmais_user
--

ALTER SEQUENCE public.user_course_id_seq OWNED BY public.user_course.id;


--
-- Name: users; Type: TABLE; Schema: public; Owner: advmais_user
--

CREATE TABLE public.users (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    email_verified_at timestamp(0) without time zone,
    password character varying(255) NOT NULL,
    role character varying(255) DEFAULT 'aluno'::character varying NOT NULL,
    is_active boolean DEFAULT true NOT NULL,
    remember_token character varying(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    CONSTRAINT users_role_check CHECK (((role)::text = ANY ((ARRAY['admin'::character varying, 'membro'::character varying, 'aluno'::character varying, 'professor'::character varying])::text[])))
);


ALTER TABLE public.users OWNER TO advmais_user;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: advmais_user
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.users_id_seq OWNER TO advmais_user;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: advmais_user
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: about_events id; Type: DEFAULT; Schema: public; Owner: advmais_user
--

ALTER TABLE ONLY public.about_events ALTER COLUMN id SET DEFAULT nextval('public.about_events_id_seq'::regclass);


--
-- Name: about_founders id; Type: DEFAULT; Schema: public; Owner: advmais_user
--

ALTER TABLE ONLY public.about_founders ALTER COLUMN id SET DEFAULT nextval('public.about_founders_id_seq'::regclass);


--
-- Name: about_settings id; Type: DEFAULT; Schema: public; Owner: advmais_user
--

ALTER TABLE ONLY public.about_settings ALTER COLUMN id SET DEFAULT nextval('public.about_settings_id_seq'::regclass);


--
-- Name: categories id; Type: DEFAULT; Schema: public; Owner: advmais_user
--

ALTER TABLE ONLY public.categories ALTER COLUMN id SET DEFAULT nextval('public.categories_id_seq'::regclass);


--
-- Name: courses id; Type: DEFAULT; Schema: public; Owner: advmais_user
--

ALTER TABLE ONLY public.courses ALTER COLUMN id SET DEFAULT nextval('public.courses_id_seq'::regclass);


--
-- Name: lesson_attachments id; Type: DEFAULT; Schema: public; Owner: advmais_user
--

ALTER TABLE ONLY public.lesson_attachments ALTER COLUMN id SET DEFAULT nextval('public.lesson_attachments_id_seq'::regclass);


--
-- Name: lesson_user id; Type: DEFAULT; Schema: public; Owner: advmais_user
--

ALTER TABLE ONLY public.lesson_user ALTER COLUMN id SET DEFAULT nextval('public.lesson_user_id_seq'::regclass);


--
-- Name: lesson_user_access id; Type: DEFAULT; Schema: public; Owner: advmais_user
--

ALTER TABLE ONLY public.lesson_user_access ALTER COLUMN id SET DEFAULT nextval('public.lesson_user_access_id_seq'::regclass);


--
-- Name: lessons id; Type: DEFAULT; Schema: public; Owner: advmais_user
--

ALTER TABLE ONLY public.lessons ALTER COLUMN id SET DEFAULT nextval('public.lessons_id_seq'::regclass);


--
-- Name: materials id; Type: DEFAULT; Schema: public; Owner: advmais_user
--

ALTER TABLE ONLY public.materials ALTER COLUMN id SET DEFAULT nextval('public.materials_id_seq'::regclass);


--
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: advmais_user
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- Name: modules id; Type: DEFAULT; Schema: public; Owner: advmais_user
--

ALTER TABLE ONLY public.modules ALTER COLUMN id SET DEFAULT nextval('public.modules_id_seq'::regclass);


--
-- Name: personal_access_tokens id; Type: DEFAULT; Schema: public; Owner: advmais_user
--

ALTER TABLE ONLY public.personal_access_tokens ALTER COLUMN id SET DEFAULT nextval('public.personal_access_tokens_id_seq'::regclass);


--
-- Name: user_category id; Type: DEFAULT; Schema: public; Owner: advmais_user
--

ALTER TABLE ONLY public.user_category ALTER COLUMN id SET DEFAULT nextval('public.user_category_id_seq'::regclass);


--
-- Name: user_course id; Type: DEFAULT; Schema: public; Owner: advmais_user
--

ALTER TABLE ONLY public.user_course ALTER COLUMN id SET DEFAULT nextval('public.user_course_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: advmais_user
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Data for Name: about_events; Type: TABLE DATA; Schema: public; Owner: advmais_user
--

COPY public.about_events (id, title, description, photo, video_url, "order", created_at, updated_at) FROM stdin;
1	Palestra - Visão de Futuro	Palestra ministrada por Anderson Barros, em setembro de 2025, em Maceió, para advogados de todo Brasil, com o tema VISÃO DE FUTURO NA ADVOCACIA.	about/events/iD9jgIzZlc6eOcFswIcXS2QgJdE6BunogLfq0xzA.png	https://www.youtube.com/watch?v=HOJZCjkjZnc	0	2026-02-12 11:22:23	2026-02-12 11:23:37
\.


--
-- Data for Name: about_founders; Type: TABLE DATA; Schema: public; Owner: advmais_user
--

COPY public.about_founders (id, name, role, bio, photo, "order", created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: about_settings; Type: TABLE DATA; Schema: public; Owner: advmais_user
--

COPY public.about_settings (id, created_at, updated_at, intro_video_url, intro_text, card_image) FROM stdin;
1	2026-02-09 18:13:58	2026-02-12 00:58:02	https://youtu.be/AvoV-Va2hsE	A ADV+ CONECTA é um ecossistema jurídico colaborativo criado para advogados que desejam crescer com mais clareza, segurança e previsibilidade, sem depender de tentativa e erro. A comunidade rompe com o isolamento tradicional da advocacia, oferecendo um ambiente estruturado de troca prática, validação de decisões e apoio contínuo entre profissionais de diferentes áreas.\r\n\r\nAqui, a inteligência artificial não substitui o advogado. Ela atua como ferramenta estratégica de apoio ao raciocínio, organização de informações, análise de cenários e redução de erros repetidos, sempre aplicada de forma orientada e prática. Somada à experiência coletiva, a tecnologia deixa de ser tendência e se torna vantagem concreta no dia a dia profissional.\r\n\r\nAo ingressar, o membro passa a integrar um ambiente vivo, atualizado semanalmente, com assistentes de IA treinados para a advocacia, treinamentos de prompts avançados, introdução a agentes e automações jurídicas, além de aulas extras frequentes com professores e advogados de todo o Brasil. A ADV+ CONECTA é para quem quer evoluir com critério, participar ativamente e transformar esforço em crescimento real.	about/CeCFLSAePjlfHWbq0JZieJXr8reebcT9LowUOzMH.png
\.


--
-- Data for Name: categories; Type: TABLE DATA; Schema: public; Owner: advmais_user
--

COPY public.categories (id, name, slug, description, "order", is_active, created_at, updated_at, cover_image) FROM stdin;
1	Aulas Extras	aulas-extras	Aulas complementares e materiais extras para o seu aprendizado	1	t	2026-02-09 18:11:14	2026-02-12 11:54:35	categories/PLjpqETRjvrJCwmtZethnFHuiaFixAgxt59HgWhx.png
2	Tecnologia Aplicada ao Direito	tecnologia-aplicada-ao-direito	Cursos de tecnologia e ferramentas digitais para advogados	2	t	2026-02-09 18:11:14	2026-02-13 02:21:56	categories/wNYWrF57juH5dAleC2V8fQljgHRjuaWwzsyP2srf.png
\.


--
-- Data for Name: courses; Type: TABLE DATA; Schema: public; Owner: advmais_user
--

COPY public.courses (id, title, description, cover_image, created_at, updated_at, is_active, preview_video_provider, preview_video_id, category_id, course_video, is_approved, created_by, thumbnail) FROM stdin;
4	Neurociência e Advocacia - Vanessa Novaes - JAN/2026	Uma aula estratégica que conecta os fundamentos da neurociência ao exercício prático da advocacia. Você compreenderá como o cérebro humano processa informações, toma decisões e reage a estímulos, aplicando esse conhecimento para aprimorar argumentação jurídica, comunicação com clientes, construção de narrativas persuasivas e desempenho em audiências.\r\n\r\nCom abordagem clara e aplicada, o encontro apresenta mecanismos cognitivos que influenciam percepção, memória, emoção e convencimento, oferecendo ferramentas concretas para atuação mais consciente, eficiente e estratégica no ambiente jurídico contemporâneo. Aula online, com conteúdo prático e imediatamente utilizável na rotina profissional.	courses/AFl7ufJ9Vjt5tElHhpPglLl51ROfw6Bvd7Lg9LL1.png	2026-02-12 11:57:48	2026-02-12 12:05:18	t	\N	\N	1	https://www.youtube.com/watch?v=R1xWlV8B7YQ	t	5	courses/thumbnails/6dIUzl2aglZJyAvjMrWJbzCSraCvuJGs912C94cU.png
5	Assistentes Jurídicos	Equipe de IA criadas para acelerar suas tarefas jurídicas.	courses/M3x05mxCMhQXD82bNfWCxbIqQadwDrJaSzxdM1zJ.png	2026-02-13 02:35:23	2026-02-16 16:14:05	t	\N	\N	2	\N	t	5	courses/thumbnails/h0aXITROMveR1fzw8CViQYgaqipsX2Sc8VHNDX5i.png
\.


--
-- Data for Name: lesson_attachments; Type: TABLE DATA; Schema: public; Owner: advmais_user
--

COPY public.lesson_attachments (id, lesson_id, filename, filepath, filetype, filesize, "order", created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: lesson_user; Type: TABLE DATA; Schema: public; Owner: advmais_user
--

COPY public.lesson_user (id, user_id, lesson_id, is_completed, progress_percentage, completed_at, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: lesson_user_access; Type: TABLE DATA; Schema: public; Owner: advmais_user
--

COPY public.lesson_user_access (id, user_id, lesson_id, available_at, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: lessons; Type: TABLE DATA; Schema: public; Owner: advmais_user
--

COPY public.lessons (id, course_id, title, "order", video_provider, video_ref_id, duration_seconds, created_at, updated_at, attachment, is_active, module_id, description) FROM stdin;
6	4	Neurociência e Advocacia	1	youtube	R1xWlV8B7YQ	\N	2026-02-12 12:08:58	2026-02-12 18:03:05	\N	t	\N	\N
7	5	Petição Inicial - Análise e Revisão Jurídica	1	youtube	HkeLkeW2h4o	\N	2026-02-16 16:18:32	2026-02-16 17:01:32	\N	t	1	Assistentes treinados para serem utilizados às análises jurídicas gerais, petições iniciais de qualquer área e revisão jurídica.
8	5	Defesa do Réu	2	youtube	HkeLkeW2h4o	\N	2026-02-17 04:58:22	2026-02-17 05:10:44	\N	t	\N	Assistentes voltados à defesa do réu.
\.


--
-- Data for Name: materials; Type: TABLE DATA; Schema: public; Owner: advmais_user
--

COPY public.materials (id, materialable_type, materialable_id, type, title, filename, filepath, filetype, filesize, url, "order", created_at, updated_at, cover_image, description) FROM stdin;
5	App\\Models\\Lesson	7	link	Tamy Criteriosa	\N	\N	\N	\N	https://chatgpt.com/g/g-682dd1f609808191bad395b92efc8429-tamy-criteriosa	0	2026-02-16 16:19:49	2026-02-16 16:19:49	materials/covers/dvzS5Ce9JdHztdTkMTe9Q4sG62A1oAxZCX1MMg4a.png	Advogada especializada na análise de casos jurídicos. Auxilio profissionais do Direito na identificação de problemas centrais, aplicação das normas e avaliação da viabilidade de ações,.
6	App\\Models\\Lesson	7	link	Redator Inicial	\N	\N	\N	\N	https://chatgpt.com/g/g-683e033d6c0481918f1419c9db28d199-redator-inicial	1	2026-02-16 17:29:33	2026-02-16 17:29:33	materials/covers/Iy7OplmTBQ4zYwc2UYBkpVyWGkFY4yy2ThjmY1wA.png	Assistente jurídico especializado na redação de petições iniciais com precisão técnica, clareza e rigor argumentativo. Utilizo normas do CPC/2015 e Lei 9.099/95, com linguagem acessível, lógica jurídica e padrão forense refinado.
7	App\\Models\\Lesson	7	link	Assistente de Revisão Jurídica	\N	\N	\N	\N	https://chatgpt.com/g/g-69319ac01e9881919a9ece4ecfad08a9-assistente-de-revisao-juridica	2	2026-02-17 03:51:00	2026-02-17 03:51:00	materials/covers/NwqShbsNEQrvGhBeFII9SMSxhwXXgzqdneEP6uU5.png	Assistente especializado em revisão técnica de petições jurídicas brasileiras.
8	App\\Models\\Lesson	7	link	Ana Lise	\N	\N	\N	\N	https://chatgpt.com/g/g-67847ab084d08191bec18b614ca79130-2-ana-lise	3	2026-02-17 03:57:35	2026-02-17 03:57:35	materials/covers/6MzFtANuRiZshvIvT1UqA5VyWtaI3tw3tMeWV8Nl.png	Assistente jurídica altamente eficiente, especializada na análise de processos. Minha característica é ser detalhista e completa, garantindo que nenhuma informação importante passe despercebida.
9	App\\Models\\Lesson	7	link	Corretor de Peças Processuais	\N	\N	\N	\N	https://chatgpt.com/g/g-6797cb5182c88191a4128782920c6379-4-corretor-de-pecas-processuais	4	2026-02-17 04:06:24	2026-02-17 04:06:24	materials/covers/dxtzc5Qo8KBwFUk6yRvbQroS3xaZO69ewCXqDZy7.png	Advogado virtual, doutor em Português Forense, especializado em revisar peças processuais. Corrijo gramática, ortografia e clareza, além de verificar conformidade jurídica com a legislação brasileira, assegurando rigor técnico e precisão linguística.
10	App\\Models\\Lesson	7	link	Joel Portuga	\N	\N	\N	\N	https://chatgpt.com/g/g-6795b83b65bc8191bdf0cb491626b3c0-1-joelportuga	5	2026-02-17 04:53:17	2026-02-17 04:53:17	materials/covers/BTg1Webysr7Iy6P074JYE6RhX0OO0U8Qoq80a9Jd.png	Assistente especializado em redação jurídica. Organizo textos seguindo a técnica “5WV” (o que, onde, como, quando e por que), garantindo clareza e simplicidade. Facilito a compreensão dos fatos narrados.
11	App\\Models\\Lesson	8	link	Contestação Guerreira	\N	\N	\N	\N	https://chatgpt.com/g/g-67aa9588fa808191ac2f8903a30b9f49-contestacao-guerreira	0	2026-02-17 05:05:56	2026-02-17 05:05:56	materials/covers/LgUTzvDwr7zJZDDgndjZwiJB4FMC7A4rbcvoXnpt.png	Advogado virtual especializado em contestações judiciais e administrativas.\r\nAnaliso petições iniciais, identifico teses de defesa, estruturo argumentos com base na legislação e oriento advogados na formulação de respostas estratégicas para rebater pedidos indevidos. Digite: começar
13	App\\Models\\Lesson	8	link	Contestação Guerreira	\N	\N	\N	\N	https://gemini.google.com/gem/1kkllo8bmKBcIOl81mlw8Ne7gVsBETSdr?usp=sharing	1	2026-02-25 16:56:15	2026-02-25 16:56:15	materials/covers/GwoC8FDGJqSl1EIY7Dg7cQJAKmR5IEdeB5RQL6kt.png	Sou uma advogada virtual especializada em contestações judiciais e administrativas. Analiso petições iniciais, identifico teses de defesa, estruturo argumentos com base na legislação e oriento advogados na formulação de respostas estratégicas para rebater pedidos indevidos .
\.


--
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: advmais_user
--

COPY public.migrations (id, migration, batch) FROM stdin;
1	0001_01_01_000000_create_users_table	1
2	2026_01_01_000001_create_lms_structure	1
3	2026_01_22_200350_create_personal_access_tokens_table	1
4	2026_01_23_203414_add_status_to_courses_table	1
5	2026_01_23_203445_create_lesson_user_table	1
6	2026_01_26_164239_add_preview_video_to_courses_table	1
7	2026_01_28_000001_create_categories_table	1
8	2026_01_28_000002_create_lesson_group_table	1
9	2026_01_28_000003_remove_groups_and_add_files	1
10	2026_01_29_015659_create_user_category_table	1
11	2026_01_29_020000_add_is_active_to_lessons	1
12	2026_01_29_025240_create_user_course_table	1
13	2026_01_29_030602_create_lesson_attachments_table	1
14	2026_01_29_214238_change_user_roles_enum	1
15	2026_01_29_220741_add_approval_fields_to_courses_table	1
16	2026_01_30_004956_add_cover_image_to_categories_table	1
17	2026_01_31_150751_create_modules_table	1
18	2026_01_31_150752_add_module_id_to_lessons_table	1
19	2026_01_31_152530_add_cover_image_and_description_to_lessons_table	1
20	2026_01_31_153138_move_cover_image_from_lessons_to_modules	1
21	2026_01_31_194012_add_thumbnail_to_courses_table	1
22	2026_01_31_202809_create_materials_table	1
23	2026_01_31_205025_create_about_events_table	1
24	2026_01_31_205026_create_about_founders_table	1
25	2026_01_31_210310_create_about_settings_table	1
26	2026_02_01_004113_create_about_settings_table	1
27	2026_02_09_175521_add_card_image_to_about_settings_table	1
28	2026_02_14_224703_add_cover_and_description_to_materials_table	2
\.


--
-- Data for Name: modules; Type: TABLE DATA; Schema: public; Owner: advmais_user
--

COPY public.modules (id, course_id, title, description, "order", is_active, created_at, updated_at, cover_image) FROM stdin;
1	5	Assistentes Gerais	Grupo de assistentes treinados para atuar em qualquer área do Direito.	0	t	2026-02-16 00:11:55	2026-02-17 05:16:37	modules/covers/xnk1C9dh2qPnIPAc4Dlos9yBe3IUkyfIDueDfMU4.png
\.


--
-- Data for Name: password_reset_tokens; Type: TABLE DATA; Schema: public; Owner: advmais_user
--

COPY public.password_reset_tokens (email, token, created_at) FROM stdin;
\.


--
-- Data for Name: personal_access_tokens; Type: TABLE DATA; Schema: public; Owner: advmais_user
--

COPY public.personal_access_tokens (id, tokenable_type, tokenable_id, name, token, abilities, last_used_at, expires_at, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: sessions; Type: TABLE DATA; Schema: public; Owner: advmais_user
--

COPY public.sessions (id, user_id, ip_address, user_agent, payload, last_activity) FROM stdin;
\.


--
-- Data for Name: user_category; Type: TABLE DATA; Schema: public; Owner: advmais_user
--

COPY public.user_category (id, user_id, category_id, created_at, updated_at) FROM stdin;
1	2	1	2026-02-12 11:58:17	2026-02-12 11:58:17
2	2	2	2026-02-13 12:11:57	2026-02-13 12:11:57
\.


--
-- Data for Name: user_course; Type: TABLE DATA; Schema: public; Owner: advmais_user
--

COPY public.user_course (id, user_id, course_id, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: advmais_user
--

COPY public.users (id, name, email, email_verified_at, password, role, is_active, remember_token, created_at, updated_at, deleted_at) FROM stdin;
1	Admin AdvMais	admin@advmais.local	\N	$2y$12$OYR.gpihMfZ5pvAXTnCBbO2mA9VVvQIJofMSoomd9pN7ULQRhzm9.	admin	t	\N	2026-02-09 18:11:14	2026-02-09 18:11:14	\N
3	Dra. Maria	maria@vip.teste	\N	$2y$12$Cd.l8Y/VEggVUiFhQCLbzOLT49dMB/Qvv4UjIIfukay09TmErbvIS	aluno	t	\N	2026-02-09 18:11:14	2026-02-09 18:11:14	\N
4	Flavio Henrique	flavioha@gmail.com	\N	$2y$12$brGXA4BY7R5Cz7c8eRZ1auyeRHCJK4/mo2Q0KWTMeVcYOgp/wZVnm	admin	t	\N	2026-02-09 18:16:27	2026-02-09 18:16:27	\N
5	Anderson Ricardo	andersonricardoadv@hotmail.com	\N	$2y$12$WTZQMYI.xZwUwao.w/mK8uROjo87oIrGG8SPEc8LE4M3emZMlfSFq	admin	t	\N	2026-02-09 18:17:34	2026-02-09 18:17:34	\N
2	Dr. João	joao@oab.teste	\N	$2y$12$nCQ7MX.9Z6l7n4xcmiIQeuPAdPq8IR0q97nNsvCkZ2CuJU0UuIyES	aluno	t	\N	2026-02-09 18:11:14	2026-02-12 01:09:08	\N
\.


--
-- Name: about_events_id_seq; Type: SEQUENCE SET; Schema: public; Owner: advmais_user
--

SELECT pg_catalog.setval('public.about_events_id_seq', 1, true);


--
-- Name: about_founders_id_seq; Type: SEQUENCE SET; Schema: public; Owner: advmais_user
--

SELECT pg_catalog.setval('public.about_founders_id_seq', 1, false);


--
-- Name: about_settings_id_seq; Type: SEQUENCE SET; Schema: public; Owner: advmais_user
--

SELECT pg_catalog.setval('public.about_settings_id_seq', 1, true);


--
-- Name: categories_id_seq; Type: SEQUENCE SET; Schema: public; Owner: advmais_user
--

SELECT pg_catalog.setval('public.categories_id_seq', 2, true);


--
-- Name: courses_id_seq; Type: SEQUENCE SET; Schema: public; Owner: advmais_user
--

SELECT pg_catalog.setval('public.courses_id_seq', 5, true);


--
-- Name: lesson_attachments_id_seq; Type: SEQUENCE SET; Schema: public; Owner: advmais_user
--

SELECT pg_catalog.setval('public.lesson_attachments_id_seq', 1, false);


--
-- Name: lesson_user_access_id_seq; Type: SEQUENCE SET; Schema: public; Owner: advmais_user
--

SELECT pg_catalog.setval('public.lesson_user_access_id_seq', 1, false);


--
-- Name: lesson_user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: advmais_user
--

SELECT pg_catalog.setval('public.lesson_user_id_seq', 1, false);


--
-- Name: lessons_id_seq; Type: SEQUENCE SET; Schema: public; Owner: advmais_user
--

SELECT pg_catalog.setval('public.lessons_id_seq', 8, true);


--
-- Name: materials_id_seq; Type: SEQUENCE SET; Schema: public; Owner: advmais_user
--

SELECT pg_catalog.setval('public.materials_id_seq', 13, true);


--
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: advmais_user
--

SELECT pg_catalog.setval('public.migrations_id_seq', 28, true);


--
-- Name: modules_id_seq; Type: SEQUENCE SET; Schema: public; Owner: advmais_user
--

SELECT pg_catalog.setval('public.modules_id_seq', 1, true);


--
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE SET; Schema: public; Owner: advmais_user
--

SELECT pg_catalog.setval('public.personal_access_tokens_id_seq', 1, false);


--
-- Name: user_category_id_seq; Type: SEQUENCE SET; Schema: public; Owner: advmais_user
--

SELECT pg_catalog.setval('public.user_category_id_seq', 2, true);


--
-- Name: user_course_id_seq; Type: SEQUENCE SET; Schema: public; Owner: advmais_user
--

SELECT pg_catalog.setval('public.user_course_id_seq', 1, false);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: advmais_user
--

SELECT pg_catalog.setval('public.users_id_seq', 5, true);


--
-- Name: about_events about_events_pkey; Type: CONSTRAINT; Schema: public; Owner: advmais_user
--

ALTER TABLE ONLY public.about_events
    ADD CONSTRAINT about_events_pkey PRIMARY KEY (id);


--
-- Name: about_founders about_founders_pkey; Type: CONSTRAINT; Schema: public; Owner: advmais_user
--

ALTER TABLE ONLY public.about_founders
    ADD CONSTRAINT about_founders_pkey PRIMARY KEY (id);


--
-- Name: about_settings about_settings_pkey; Type: CONSTRAINT; Schema: public; Owner: advmais_user
--

ALTER TABLE ONLY public.about_settings
    ADD CONSTRAINT about_settings_pkey PRIMARY KEY (id);


--
-- Name: categories categories_pkey; Type: CONSTRAINT; Schema: public; Owner: advmais_user
--

ALTER TABLE ONLY public.categories
    ADD CONSTRAINT categories_pkey PRIMARY KEY (id);


--
-- Name: categories categories_slug_unique; Type: CONSTRAINT; Schema: public; Owner: advmais_user
--

ALTER TABLE ONLY public.categories
    ADD CONSTRAINT categories_slug_unique UNIQUE (slug);


--
-- Name: courses courses_pkey; Type: CONSTRAINT; Schema: public; Owner: advmais_user
--

ALTER TABLE ONLY public.courses
    ADD CONSTRAINT courses_pkey PRIMARY KEY (id);


--
-- Name: lesson_attachments lesson_attachments_pkey; Type: CONSTRAINT; Schema: public; Owner: advmais_user
--

ALTER TABLE ONLY public.lesson_attachments
    ADD CONSTRAINT lesson_attachments_pkey PRIMARY KEY (id);


--
-- Name: lesson_user_access lesson_user_access_pkey; Type: CONSTRAINT; Schema: public; Owner: advmais_user
--

ALTER TABLE ONLY public.lesson_user_access
    ADD CONSTRAINT lesson_user_access_pkey PRIMARY KEY (id);


--
-- Name: lesson_user_access lesson_user_access_user_id_lesson_id_unique; Type: CONSTRAINT; Schema: public; Owner: advmais_user
--

ALTER TABLE ONLY public.lesson_user_access
    ADD CONSTRAINT lesson_user_access_user_id_lesson_id_unique UNIQUE (user_id, lesson_id);


--
-- Name: lesson_user lesson_user_pkey; Type: CONSTRAINT; Schema: public; Owner: advmais_user
--

ALTER TABLE ONLY public.lesson_user
    ADD CONSTRAINT lesson_user_pkey PRIMARY KEY (id);


--
-- Name: lesson_user lesson_user_user_id_lesson_id_unique; Type: CONSTRAINT; Schema: public; Owner: advmais_user
--

ALTER TABLE ONLY public.lesson_user
    ADD CONSTRAINT lesson_user_user_id_lesson_id_unique UNIQUE (user_id, lesson_id);


--
-- Name: lessons lessons_pkey; Type: CONSTRAINT; Schema: public; Owner: advmais_user
--

ALTER TABLE ONLY public.lessons
    ADD CONSTRAINT lessons_pkey PRIMARY KEY (id);


--
-- Name: materials materials_pkey; Type: CONSTRAINT; Schema: public; Owner: advmais_user
--

ALTER TABLE ONLY public.materials
    ADD CONSTRAINT materials_pkey PRIMARY KEY (id);


--
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: advmais_user
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- Name: modules modules_pkey; Type: CONSTRAINT; Schema: public; Owner: advmais_user
--

ALTER TABLE ONLY public.modules
    ADD CONSTRAINT modules_pkey PRIMARY KEY (id);


--
-- Name: password_reset_tokens password_reset_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: advmais_user
--

ALTER TABLE ONLY public.password_reset_tokens
    ADD CONSTRAINT password_reset_tokens_pkey PRIMARY KEY (email);


--
-- Name: personal_access_tokens personal_access_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: advmais_user
--

ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_pkey PRIMARY KEY (id);


--
-- Name: personal_access_tokens personal_access_tokens_token_unique; Type: CONSTRAINT; Schema: public; Owner: advmais_user
--

ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_token_unique UNIQUE (token);


--
-- Name: sessions sessions_pkey; Type: CONSTRAINT; Schema: public; Owner: advmais_user
--

ALTER TABLE ONLY public.sessions
    ADD CONSTRAINT sessions_pkey PRIMARY KEY (id);


--
-- Name: user_category user_category_pkey; Type: CONSTRAINT; Schema: public; Owner: advmais_user
--

ALTER TABLE ONLY public.user_category
    ADD CONSTRAINT user_category_pkey PRIMARY KEY (id);


--
-- Name: user_category user_category_user_id_category_id_unique; Type: CONSTRAINT; Schema: public; Owner: advmais_user
--

ALTER TABLE ONLY public.user_category
    ADD CONSTRAINT user_category_user_id_category_id_unique UNIQUE (user_id, category_id);


--
-- Name: user_course user_course_pkey; Type: CONSTRAINT; Schema: public; Owner: advmais_user
--

ALTER TABLE ONLY public.user_course
    ADD CONSTRAINT user_course_pkey PRIMARY KEY (id);


--
-- Name: user_course user_course_user_id_course_id_unique; Type: CONSTRAINT; Schema: public; Owner: advmais_user
--

ALTER TABLE ONLY public.user_course
    ADD CONSTRAINT user_course_user_id_course_id_unique UNIQUE (user_id, course_id);


--
-- Name: users users_email_unique; Type: CONSTRAINT; Schema: public; Owner: advmais_user
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: advmais_user
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: materials_materialable_type_materialable_id_index; Type: INDEX; Schema: public; Owner: advmais_user
--

CREATE INDEX materials_materialable_type_materialable_id_index ON public.materials USING btree (materialable_type, materialable_id);


--
-- Name: personal_access_tokens_expires_at_index; Type: INDEX; Schema: public; Owner: advmais_user
--

CREATE INDEX personal_access_tokens_expires_at_index ON public.personal_access_tokens USING btree (expires_at);


--
-- Name: personal_access_tokens_tokenable_type_tokenable_id_index; Type: INDEX; Schema: public; Owner: advmais_user
--

CREATE INDEX personal_access_tokens_tokenable_type_tokenable_id_index ON public.personal_access_tokens USING btree (tokenable_type, tokenable_id);


--
-- Name: sessions_last_activity_index; Type: INDEX; Schema: public; Owner: advmais_user
--

CREATE INDEX sessions_last_activity_index ON public.sessions USING btree (last_activity);


--
-- Name: sessions_user_id_index; Type: INDEX; Schema: public; Owner: advmais_user
--

CREATE INDEX sessions_user_id_index ON public.sessions USING btree (user_id);


--
-- Name: users_role_index; Type: INDEX; Schema: public; Owner: advmais_user
--

CREATE INDEX users_role_index ON public.users USING btree (role);


--
-- Name: courses courses_category_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: advmais_user
--

ALTER TABLE ONLY public.courses
    ADD CONSTRAINT courses_category_id_foreign FOREIGN KEY (category_id) REFERENCES public.categories(id) ON DELETE SET NULL;


--
-- Name: courses courses_created_by_foreign; Type: FK CONSTRAINT; Schema: public; Owner: advmais_user
--

ALTER TABLE ONLY public.courses
    ADD CONSTRAINT courses_created_by_foreign FOREIGN KEY (created_by) REFERENCES public.users(id) ON DELETE SET NULL;


--
-- Name: lesson_attachments lesson_attachments_lesson_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: advmais_user
--

ALTER TABLE ONLY public.lesson_attachments
    ADD CONSTRAINT lesson_attachments_lesson_id_foreign FOREIGN KEY (lesson_id) REFERENCES public.lessons(id) ON DELETE CASCADE;


--
-- Name: lesson_user_access lesson_user_access_lesson_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: advmais_user
--

ALTER TABLE ONLY public.lesson_user_access
    ADD CONSTRAINT lesson_user_access_lesson_id_foreign FOREIGN KEY (lesson_id) REFERENCES public.lessons(id) ON DELETE CASCADE;


--
-- Name: lesson_user_access lesson_user_access_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: advmais_user
--

ALTER TABLE ONLY public.lesson_user_access
    ADD CONSTRAINT lesson_user_access_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: lesson_user lesson_user_lesson_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: advmais_user
--

ALTER TABLE ONLY public.lesson_user
    ADD CONSTRAINT lesson_user_lesson_id_foreign FOREIGN KEY (lesson_id) REFERENCES public.lessons(id) ON DELETE CASCADE;


--
-- Name: lesson_user lesson_user_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: advmais_user
--

ALTER TABLE ONLY public.lesson_user
    ADD CONSTRAINT lesson_user_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: lessons lessons_course_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: advmais_user
--

ALTER TABLE ONLY public.lessons
    ADD CONSTRAINT lessons_course_id_foreign FOREIGN KEY (course_id) REFERENCES public.courses(id) ON DELETE CASCADE;


--
-- Name: lessons lessons_module_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: advmais_user
--

ALTER TABLE ONLY public.lessons
    ADD CONSTRAINT lessons_module_id_foreign FOREIGN KEY (module_id) REFERENCES public.modules(id) ON DELETE SET NULL;


--
-- Name: modules modules_course_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: advmais_user
--

ALTER TABLE ONLY public.modules
    ADD CONSTRAINT modules_course_id_foreign FOREIGN KEY (course_id) REFERENCES public.courses(id) ON DELETE CASCADE;


--
-- Name: user_category user_category_category_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: advmais_user
--

ALTER TABLE ONLY public.user_category
    ADD CONSTRAINT user_category_category_id_foreign FOREIGN KEY (category_id) REFERENCES public.categories(id) ON DELETE CASCADE;


--
-- Name: user_category user_category_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: advmais_user
--

ALTER TABLE ONLY public.user_category
    ADD CONSTRAINT user_category_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: user_course user_course_course_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: advmais_user
--

ALTER TABLE ONLY public.user_course
    ADD CONSTRAINT user_course_course_id_foreign FOREIGN KEY (course_id) REFERENCES public.courses(id) ON DELETE CASCADE;


--
-- Name: user_course user_course_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: advmais_user
--

ALTER TABLE ONLY public.user_course
    ADD CONSTRAINT user_course_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--

\unrestrict KMKev2yrngI64zq3Ai4BHE3hUiIdKLBEmxPMYcXvHnbidm9WtpzAWjF8AAAGaEQ

